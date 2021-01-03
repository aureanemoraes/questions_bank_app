<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CadernoQuestao;
use Illuminate\Support\Facades\Auth;


class CadernosQuestoesController extends Controller
{
    public function listarCadernosQuestoesPorAutor($user_id) {
        //$assuntos = Assunto::select('id', 'nome AS text')->get();
        $cadernos_questoes = CadernoQuestao::select('id', 'titulo AS text')->where('user_id',$user_id )->orderByDesc('created_at')->get();
        return $cadernos_questoes;
    }
}
