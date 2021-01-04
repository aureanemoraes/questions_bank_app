<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('cadernos_questoes/pre-create', function() {
    return view('professor.cadernos_questoes.pre-create');
});
Route::post('estudante/cadernos_questoes/{cq_id}', 'Aluno\CadernosQuestoesController@salvarRespostas')->name('aluno_cq.store');

Route::get('estudante/responder/caderno_questao/{id}', 'Aluno\CadernosQuestoesController@showAvaliation')->name('aluno_cq.avaliation');

Route::get('estudante/cadernos_questoes', 'Aluno\CadernosQuestoesController@index');
Route::get('estudante/cadernos_questoes/{id}', 'Aluno\CadernosQuestoesController@show')->name('aluno_cq.show');

Route::get('questoes/minhas', 'Professor\QuestoesController@my_index');
Route::resource('questoes', 'Professor\QuestoesController');
Route::get('cadernos_questoes/meus', 'Professor\CadernosQuestoesController@my_index');

Route::resource('cadernos_questoes', 'Professor\CadernosQuestoesController');

