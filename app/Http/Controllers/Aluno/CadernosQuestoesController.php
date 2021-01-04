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
        return view('aluno.cadernos_questoes.avaliation');
    }
}
