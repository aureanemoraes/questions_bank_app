<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CadernoQuestao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CadernosQuestoesController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        return view('professor.cadernos_questoes.create');
    }

    public function store(Request $request)
    {
        $data_inicial = Carbon::createFromFormat('d/m/Y', $request->data_inicial);
        $data_final = Carbon::createFromFormat('d/m/Y', $request->data_final);
        $duracao = Carbon::createFromFormat('H:i:s', $request->duracao);

        $caderno_questao = CadernoQuestao::create([
            'titulo' => $request->titulo,
            'informacoes_adicionais' => $request->informacoes_adicionais,
            'data_inicial' => $data_inicial,
            'data_final' => $data_final,
            'duracao' => $duracao,
            'quantidade_questoes' => $request->quantidade_questoes,
            'nota_maxima' => $request->nota_maxima,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'privacidade' => $request->privacidade,
            'cq_enem_id' => $request->cq_enem_id,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('cadernos_questoes.show', [$caderno_questao]);
    }

    public function show($id)
    {
        $caderno_questao = CadernoQuestao::find($id);
        return view('professor.cadernos_questoes.show', compact('caderno_questao'));
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        //
    }
}
