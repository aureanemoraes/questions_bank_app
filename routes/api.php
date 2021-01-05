<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/matrizes', 'Api\MatrizesController@opcoes');
Route::get('/componentes', 'Api\ComponentesController@opcoes');
Route::get('/assuntos', 'Api\AssuntosController@opcoes');
Route::get('/alunos', 'Api\AlunosController@opcoes');
Route::get('/cadernos_questoes/{user_id}', 'Api\CadernosQuestoesController@listarCadernosQuestoesPorAutor');
Route::post('/assuntos', 'Api\AssuntosController@store');
Route::post('/imagens', 'Api\ImagemController@store');
Route::post('/opcoes/{questao_id}', 'Api\OpcoesController@store');
Route::post('/cadernos_questoes', 'Api\CadernosQuestoesController@adicionarQuestao');
Route::post('/cadernos_questoes/{cq_id}/{aluno_id}', 'Api\CadernosQuestoesController@adicionarAluno');
Route::put('/opcoes/{id}', 'Api\OpcoesController@update');
Route::delete('/imagens/{id}', 'Api\ImagemController@destroy');
Route::delete('/opcoes/{id}', 'Api\OpcoesController@destroy');
Route::delete('/cadernos_questoes/{questao_id}/{cq_id}', 'Api\CadernosQuestoesController@excluirQuestao');




