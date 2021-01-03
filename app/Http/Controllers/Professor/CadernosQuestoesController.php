<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CadernoQuestao;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CadernosQuestoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function my_index() {
        $id = Auth::id();
        $cadernos_questoes = CadernoQuestao::where('user_id', $id)->get();
        return view('professor.cadernos_questoes.index', compact('cadernos_questoes'));
    }

    public function index()
    {
        $cadernos_questoes = CadernoQuestao::all();
        return view('professor.cadernos_questoes.index', compact('cadernos_questoes'));
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
        
        if($request->alunos) {
            $caderno_questao->alunos()->attach($request->alunos);
        }

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
        $caderno_questao = CadernoQuestao::find($id);
        $caderno_questao->load('alunos');
        return view('professor.cadernos_questoes.edit', compact('caderno_questao'));
    }

    public function update(Request $request, $id)
    {
        $caderno_questao = CadernoQuestao::find($id);

        $data_inicial = Carbon::createFromFormat('d/m/Y', $request->data_inicial);
        $data_final = Carbon::createFromFormat('d/m/Y', $request->data_final);
        $duracao = Carbon::createFromFormat('H:i:s', $request->duracao);

        $backup_qtde_questoes = $caderno_questao->quantidade_questoes;
        $backup_nota_maxima = $caderno_questao->nota_maxima;

        $caderno_questao->fill([
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
            'cq_enem_id' => $request->cq_enem_id
        ]);
        $caderno_questao->save();

        if($request->alunos) {
            $caderno_questao->alunos()->sync($request->alunos);
        } else {
            $caderno_questao->alunos()->detach();
        }

        // recalcular os valores das questões
        if(($backup_qtde_questoes != $caderno_questao->quantidade_questoes) || ($backup_nota_maxima != $caderno_questao->nota_maxima)) {
            if($caderno_questao->quantidade_questoes > $caderno_questao->nota_maxima) {
                $valor_questao = $caderno_questao->quantidade_questoes/$caderno_questao->nota_maxima;
            } else {
                $valor_questao = $caderno_questao->nota_maxima/$caderno_questao->quantidade_questoes;
            }

            foreach($caderno_questao->questoes as $questao) {
                $caderno_questao->questoes()->sync([$questao->id => ['valor' => $valor_questao]]);
            }
        }

        return redirect()->route('cadernos_questoes.show', [$caderno_questao]);
    }
    
    public function destroy($id)
    {
        $cq = CadernoQuestao::find($id);
        $cq->questoes()->detach();
        $cq->delete();
        return 1;
    }
}
