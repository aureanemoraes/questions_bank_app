<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\CadernoQuestao;
use App\Models\RespostaDiscursiva;



class CadernosQuestoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        //$id = Auth::id();
        $aluno = User::find(Auth::id());
        $cadernos_questoes = $aluno->cadernos_questoes;
        $ids = $aluno->cadernos_questoes->pluck('id');

        // verificar os cadernos de questões publicos e adicionar a variavel
        $cadernos_questoes_publicos = CadernoQuestao::where('privacidade', 'Público')->whereNotIn('id', $ids)->get();

        return view('aluno.cadernos_questoes.index', compact('cadernos_questoes', 'cadernos_questoes_publicos'));
    }

    public function show($id)
    {
        $aluno = User::find(Auth::id());
        $caderno_questao = $aluno->cadernos_questoes()->where('caderno_questao_id', $id)->first();
        if($caderno_questao) {
            return view('aluno.cadernos_questoes.show', compact('caderno_questao'));
        } else {
            $caderno_questao = CadernoQuestao::find($id);
            return view('aluno.cadernos_questoes.show', compact('caderno_questao'));
        }
        //
    }

    public function showAvaliation($id)
    {
        $aluno = User::find(Auth::id());
        $caderno_questao = $aluno->cadernos_questoes()->where('caderno_questao_id', $id)->first();
        return view('aluno.cadernos_questoes.avaliation', compact('caderno_questao'));
    }

    public function salvarRespostas($caderno_questao_id, Request $request) {
        $aluno = User::find(Auth::id());
        $caderno_questao = $aluno->cadernos_questoes()->where('caderno_questao_id', $caderno_questao_id)->first();

        if($caderno_questao->pivot->situacao == 'aberto') {
            foreach($caderno_questao->questoes as $questao) {
                switch($questao->tipo_resposta) {
                    case 'Única Escolha':
                        foreach($questao->opcoes as $opcao) {
                            if($opcao->correta) {
                                if(isset($request->resposta[$questao->id][$opcao->id])) {
                                    // está correta // dar os pontos
                                    $antiga_nota = $caderno_questao->pivot->nota;
                                    $nota_questao = $questao->pivot->valor;
                                    $nova_nota = $antiga_nota + $nota_questao;
                                    //$aluno->cadernos_questoes()->sync([$caderno_questao->id => ['nota' => $nova_nota]]);

                                    //$employee->requirements()->updateExistingPivot($requirement->id, $attributes);
                                    $aluno->cadernos_questoes()->updateExistingPivot($caderno_questao->id, ['nota' => $nova_nota]);

                                }
                            }
                        }
                        break;
                    case 'Múltipla Escolha':
                        $opcoes_corretas = 0;
                        $acertos = 0;
                        foreach($questao->opcoes as $opcao) {
                            if($opcao->correta) {
                                if(isset($request->resposta[$questao->id][$opcao->id])) {
                                    // está correta // dar os pontos
                                    $acertos++;
                                }
                                $opcoes_corretas++;
                            }
                        }
                        if($opcoes_corretas == $acertos) {
                            $antiga_nota = $caderno_questao->pivot->nota;
                            $nota_questao = $questao->pivot->valor;
                            $nova_nota = $antiga_nota + $nota_questao;
    
                            $aluno->cadernos_questoes()->updateExistingPivot($caderno_questao->id, ['nota' => $nova_nota]);
                        }
                        break;
                    case 'Discursiva':
                        if($request->resposta[$questao->id]['texto']) {
                            RespostaDiscursiva::create([
                                'texto' => $request->resposta[$questao->id]['texto'],
                                'questao_id' => $questao->id
                            ]);
                            $aluno->cadernos_questoes()->updateExistingPivot($caderno_questao->id, ['situacao' => 'pendente']);

                           // $aluno->cadernos_questoes()->sync([$caderno_questao->id => ['situacao' => 'pendente']]);

                           // $caderno_questao->alunos()->sync([$aluno->id => ['situacao' => 'pendente']]);
                        }
                        break;
                }
            }
    
            if($caderno_questao->pivot->situacao == 'aberto') {
                $aluno->cadernos_questoes()->updateExistingPivot($caderno_questao->id, ['situacao' => 'finalizado']);

                //$aluno->cadernos_questoes()->sync([$caderno_questao->id => ['situacao' => 'pendente']]);
                //$caderno_questao->alunos()->sync([$aluno->id => ['situacao' => 'Finalizado']]);
    
            }
        }
        

        return 'a';
    }
}
