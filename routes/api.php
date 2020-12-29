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
Route::post('/assuntos', 'Api\AssuntosController@store');
Route::post('/imagens', 'Api\ImagemController@store');
Route::delete('/imagens/{id}', 'Api\ImagemController@destroy');


