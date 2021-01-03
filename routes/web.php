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
Route::get('questoes/minhas', 'Professor\QuestoesController@my_index');
Route::resource('questoes', 'Professor\QuestoesController');
Route::get('cadernos_questoes/meus', 'Professor\CadernosQuestoesController@my_index');

Route::resource('cadernos_questoes', 'Professor\CadernosQuestoesController');

