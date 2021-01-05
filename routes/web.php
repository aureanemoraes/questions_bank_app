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


Route::get('admin/users', 'Admin\UsuariosController@index');
Route::get('admin/users/{id}', 'Admin\UsuariosController@edit')->name('users.edit');
Route::put('admin/users/{id}', 'Admin\UsuariosController@update')->name('users.update');



Route::get('estudante/cadernos_questoes', 'Aluno\CadernosQuestoesController@index')->name('aluno_cq.index');
Route::get('estudante/cadernos_questoes/{id}', 'Aluno\CadernosQuestoesController@show')->name('aluno_cq.show');
Route::post('estudante/cadernos_questoes/teste/{cq_id}', 'Aluno\CadernosQuestoesController@salvarRespostas')->name('aluno_cq.salvar');
Route::get('estudante/responder/caderno_questao/{id}', 'Aluno\CadernosQuestoesController@showAvaliation')->name('aluno_cq.avaliation');
Route::get('questoes/minhas', 'Professor\QuestoesController@my_index');
Route::resource('questoes', 'Professor\QuestoesController');
Route::get('cadernos_questoes/pendentes', 'Professor\CadernosQuestoesController@indexPendentes')->name('cadernos_questoes_pendentes.index');
Route::get('cadernos_questoes/pendentes/{cq_id}/{user_id}', 'Professor\CadernosQuestoesController@showPendentes')->name('cadernos_questoes_pendentes.show');;
Route::post('cadernos_questoes/pendentes/{cq_id}', 'Professor\CadernosQuestoesController@updateGrade')->name('cadernos_questoes.pendentes.update');
Route::get('cadernos_questoes/meus', 'Professor\CadernosQuestoesController@my_index');
Route::resource('cadernos_questoes', 'Professor\CadernosQuestoesController');


