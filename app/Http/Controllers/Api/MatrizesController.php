<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Matriz;


class MatrizesController extends Controller
{
    public function opcoes() {
        $matrizes = Matriz::select('id', 'nome AS text')->get();

        return $matrizes;
    } 
}
