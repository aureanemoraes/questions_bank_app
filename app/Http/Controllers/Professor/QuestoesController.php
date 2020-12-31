<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questao;
use App\Models\Matriz;
use App\Models\Componente;
use App\Models\Imagem;
use App\Models\Opcao;
use Image;
use Illuminate\Support\Facades\Auth;

class QuestoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $questoes = Questao::all();
        return view('professor.questoes.index', compact('questoes'));
    }

    public function create() {
        return view('professor.questoes.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'comando' => ['required', 'string'],
            'tipo_resposta' => ['required', 'string'],
            'nivel_dificuldade' => ['required', 'string'],
            'matriz_id' => ['required', 'integer'],
            'componente_id' => ['required', 'integer'],
            'assunto_id' => ['required', 'integer'],
        ]);

        // área de conhecimento
        $matriz = Matriz::find($request->matriz_id);
        $componente = Componente::find($request->componente_id);
        $area_conhecimento = $this->definirAreaConhecimento($matriz->nome, $componente->nome); 

        $questao = Questao::create([
            'comando' => $request->comando,
            'tipo_resposta' => $request->tipo_resposta,
            'nivel_dificuldade' => $request->nivel_dificuldade,
            'matriz_id' => $request->matriz_id,
            'componente_id' => $request->componente_id,
            'assunto_id' => $request->assunto_id,
            'area_conhecimento_id' => $area_conhecimento,
            'user_id' => Auth::id()
        ]);

        // Verificando se há opções e armazenando
        if($request->opcoes) {
            // Armazenando questão de única escolha
            if($questao->tipo_resposta == 'Única Escolha') {
                for($i=0 ; $i<5 ; $i++) {
                    // opcao com imagem
                    if($request->hasFile("imagem_$i")) {
                        $nome_imagem = $this->salvarImagem($request->file("imagem_$i"));

                        if($i == $request->correta) {
                            $opcao = Opcao::create([
                                'texto' => $nome_imagem,
                                'questao_id' => $questao->id,
                                'correta' => true,
                                'imagem' => true
                            ]);
                        } else {
                            $opcao = Opcao::create([
                                'texto' => $nome_imagem,
                                'questao_id' => $questao->id,
                                'correta' => false,
                                'imagem' => true
                            ]);
                        }
                    } 
                    // opcao sem imagem
                    if(isset($request->opcoes[$i]['texto'])) {
                        if($i == $request->correta) {
                            $opcao = Opcao::create([
                                'texto' => $request->opcoes[$i]['texto'],
                                'questao_id' => $questao->id,
                                'correta' => true
                            ]);
                        } else {
                            $opcao = Opcao::create([
                                'texto' => $request->opcoes[$i]['texto'],
                                'questao_id' => $questao->id,
                                'correta' => false
                            ]);
                        }
                    }
                }
            }
            // Armazenando questão de múltipla escolha
            if($questao->tipo_resposta == 'Múltipla Escolha') {
                $i = 0;
                foreach($request->opcoes as $item) {
                    // opcao com imagem
                    if($request->hasFile("imagem_$i")) {
                        $nome_imagem = $this->salvarImagem($request->file("imagem_$i"));

                        if(isset($item['correta'])) {
                            $opcao = Opcao::create([
                                'texto' => $nome_imagem,
                                'questao_id' => $questao->id,
                                'correta' => true,
                                'imagem' => true
                            ]);
                        } else {
                            $opcao = Opcao::create([
                                'texto' => $nome_imagem,
                                'questao_id' => $questao->id,
                                'correta' => false,
                                'imagem' => true
                            ]);
                        }
                    }  
                    // opcao sem imagem
                    if(isset($item['texto'])) {
                        if(isset($item['correta'])) {
                            $opcao = Opcao::create([
                                'texto' => $item['texto'],
                                'questao_id' => $questao->id,
                                'correta' => true
                            ]);
                        } else {
                            $opcao = Opcao::create([
                                'texto' => $item['texto'],
                                'questao_id' => $questao->id,
                                'correta' => false
                            ]);
                        }
                    }
                    $i++;
                }
            }
        }

        // tratar imagens e armazenar
        if($request->hasFile('imagens')) {
            $numeracao_imagem = 1;
            $imagens = $request->file('imagens');
            foreach($imagens as $imagem) {
                $nome_imagem = time().'_'. $imagem->getClientOriginalName();
                $caminho_arquivo = public_path('imagens/questoes') . '/' . $nome_imagem;
                // Verificando tamanho da imagem
                $height = Image::make($imagem)->height();
                $width = Image::make($imagem)->width();
                if($height > 350 || $width >350) {
                    $img = Image::make($imagem->path());
                    $img->resize(350, 350, function ($const) {
                        $const->aspectRatio();
                    })->save($caminho_arquivo);
                    $nova_imagem = Imagem::create([
                        'caminho' => $nome_imagem,
                        'legenda' => "Figura $numeracao_imagem",
                        'questao_id' => $questao->id
                    ]);
                    $numeracao_imagem++;
                } else {
                    $img = Image::make($imagem->path())->save($caminho_arquivo); 
                    $nova_imagem = Imagem::create([
                        'caminho' => $nome_imagem,
                        'legenda' => "Figura $numeracao_imagem",
                        'questao_id' => $questao->id
                    ]);
                    $numeracao_imagem++;
                }
            }
        }


        return redirect()->route('questoes.show', [$questao]);

    }

    public function show($id) {
        $questao = Questao::find($id);
        return view('professor.questoes.show', compact('questao'));
    }

    public function edit($id) {
        $questao = Questao::find($id);
        $questao->load('opcoes');
        return view('professor.questoes.edit', compact('questao'));
    }

    public function update($id, Request $request) {
        $questao = Questao::find($id);

        // área de conhecimento
        $matriz = Matriz::find($request->matriz_id);
        $componente = Componente::find($request->componente_id);
        $area_conhecimento = $this->definirAreaConhecimento($matriz->nome, $componente->nome); 

        $questao->array_fill_keys([
            'comando' => $request->comando,
            'tipo_resposta' => $request->tipo_resposta,
            'nivel_dificuldade' => $request->nivel_dificuldade,
            'matriz_id' => $request->matriz_id,
            'componente_id' => $request->componente_id,
            'assunto_id' => $request->assunto_id,
            'area_conhecimento_id' => $area_conhecimento
        ]);
        $questao->save();

        // tratar imagens e armazenar
        if($request->hasFile('imagens')) {
            $numeracao_imagem = 1;
            $imagens = $request->file('imagens');
            foreach($imagens as $imagem) {
                $nome_imagem = time().'_'. $imagem->getClientOriginalName();
                $caminho_arquivo = public_path('imagens/questoes') . '/' . $nome_imagem;
                // Verificando tamanho da imagem
                $height = Image::make($imagem)->height();
                $width = Image::make($imagem)->width();
                if($height > 350 || $width >350) {
                    $img = Image::make($imagem->path());
                    $img->resize(350, 350, function ($const) {
                        $const->aspectRatio();
                    })->save($caminho_arquivo);
                    $nova_imagem = Imagem::create([
                        'caminho' => $nome_imagem,
                        'legenda' => "Figura $numeracao_imagem",
                        'questao_id' => $questao->id
                    ]);
                    $numeracao_imagem++;
                } else {
                    $img = Image::make($imagem->path())->save($caminho_arquivo); 
                    $nova_imagem = Imagem::create([
                        'caminho' => $nome_imagem,
                        'legenda' => "Figura $numeracao_imagem",
                        'questao_id' => $questao->id
                    ]);
                    $numeracao_imagem++;
                }
            }
        }
        
        return redirect()->route('questoes.show', [$questao]);


    }

    public function destroy() {
        
    }

    private function definirAreaConhecimento($matriz, $componente) {
        if(str_contains($matriz, 'Ensino Médio')) {
            switch($componente) {
                case 'Língua Portuguesa e Literatura':
                case 'Arte':
                case 'Educação Física':
                    return 1; // LINGUAGENS, CÓDIGO E SUAS TECNOLOGIAS
                break;
                case 'Matemática':
                case 'Física':
                case 'Química':
                case 'Biologia':
                    return 2; // CIÊNCIAS NATURAIS E SUAS TECNOLOGIAS
                break;
                case 'História':
                case 'Geografia':
                case 'Filosofia':
                case 'Sociologia':
                    return 2; // CIÊNCIAS HUMANAS E SUAS TECNOLOGIAS
                break;
            }
        }
    }

    private function salvarImagem($imagem) {
        $nome_imagem = time().'_'. $imagem->getClientOriginalName();
        $caminho_arquivo = public_path('imagens/opcoes') . '/' . $nome_imagem;
        // Verificando tamanho da imagem
        $height = Image::make($imagem)->height();
        $width = Image::make($imagem)->width();
        if($height > 350 || $width >350) {
            $img = Image::make($imagem->path());
            $img->resize(350, 350, function ($const) {
                $const->aspectRatio();
            })->save($caminho_arquivo);
        } else {
            $img = Image::make($imagem->path())->save($caminho_arquivo); 
        }

        return $nome_imagem;        
    }
}
