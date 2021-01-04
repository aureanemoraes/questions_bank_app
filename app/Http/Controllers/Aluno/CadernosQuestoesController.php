<?php

namespace App\Http\Controllers\Aluno;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\CadernoQuestao;


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
        // verificar os cadernos de questões publicos e adicionar a variavel
        $cadernos_questoes_publicos = CadernoQuestao::where('privacidade', 'Público')->get();
        if(count($cadernos_questoes_publicos) > 0) {
            return view('aluno.cadernos_questoes.index', compact('cadernos_questoes', 'cadernos_questoes_publicos'));
        }

        return view('aluno.cadernos_questoes.index', compact('cadernos_questoes'));
    }

    public function show($id)
    {
        $aluno = User::find(Auth::id());
        $caderno_questao = $aluno->cadernos_questoes()->where('caderno_questao_id', $id)->first();
        return view('aluno.cadernos_questoes.show', compact('caderno_questao'));
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

        foreach($caderno_questao->questoes as $questao) {
            switch($questao->tipo_resposta) {
                case 'Única Escolha':
                    foreach($questao->opcoes as $opcao) {
                        if($opcao->correta) {
                            if(isset($request->resposta[$questao->id][$opcao->id])) {
                                // está correta // dar os pontos
                                $antiga_nota = $caderno_questao->pivot->nota;
                                $nota_questao = $questao->pivot->valor;
                                $nova_nota = $antiga_nota + $nova_questao;
                                $caderno_questao->alunos()->sync([$aluno => ['nota' => $nova_nota]]);
                            }
                        }
                    }
                    break;
                case 'Múltipla Escolha':
                    foreach($questao->opcoes as $opcao) {
                        $opcoes_corretas = 0;
                        $acertos = 0;
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
                        $nova_nota = $antiga_nota + $nova_questao;

                        $caderno_questao->alunos()->sync([$aluno => ['nota' => $nova_nota]]);
                    }
                    break;
                case 'Discursiva':
                    break;
            }
        }

        return 1;
    }
}
