<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CadernoQuestao;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;


class CadernosQuestoesController extends Controller
{
    public function excluirQuestao($questao_id, $cq_id) {
        $cq = CadernoQuestao::find($cq_id);
        $cq->questoes()->detach($questao_id);

        return 1;
    }

    public function adicionarQuestao(Request $request) {
        $cq_id = $request->input('cq_id');
        $questao_id = $request->input('questao_id');
        $cq = CadernoQuestao::find($cq_id);
        // Verificando limite de questões
        if(count($cq->questoes) == $cq->quantidade_questoes) {
            return -1;
        }
        // Verificar se a questão já é adicionada
        foreach($cq->questoes as $questao) {
            if($questao->id == $questao_id) {
                return 0;
            }
        }

        if($cq->quantidade_questoes > $cq->nota_maxima) {
            $valor_questao = $cq->quantidade_questoes/$cq->nota_maxima;
        } else {
            $valor_questao = $cq->nota_maxima/$cq->quantidade_questoes;
        }

        $cq->questoes()->attach($questao_id, ['valor'=> $valor_questao ]);
        return 1;

    }

    public function listarCadernosQuestoesPorAutor($user_id) {
        //$assuntos = Assunto::select('id', 'nome AS text')->get();
        $cadernos_questoes = CadernoQuestao::select('id', 'titulo AS text')->where('user_id',$user_id )->orderByDesc('created_at')->get();
        return $cadernos_questoes;
    }

    public function adicionarAluno($caderno_questao_id, $aluno_id) {
        $user = User::find($aluno_id);
        $caderno_questao = $user->cadernos_questoes()->where('caderno_questao_id', $caderno_questao_id)->first();

        if(!$caderno_questao) {
            $user->cadernos_questoes()->attach([$caderno_questao_id => ['started_at' => Carbon::now(), 'situacao' => 'aberto']]);
        } else {
            if($caderno_questao->pivot->started_at == null) {
                $user->cadernos_questoes()->updateExistingPivot($caderno_questao->id, ['started_at' => Carbon::now()]);
            }
        }

        return 1;
    }
}
