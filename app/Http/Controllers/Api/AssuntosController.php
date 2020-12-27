<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assunto;

class AssuntosController extends Controller
{
    public function opcoes() {
        $assuntos = Assunto::select('id', 'nome AS text')->get();

        return $assuntos;
    } 

    public function store(Request $request) {
        $novo_assunto = Assunto::create([
            'nome' => $request->input('nome')
        ]);

        return 1;
    }
}
