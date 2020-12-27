<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Componente;


class ComponentesController extends Controller
{
    public function opcoes() {
        $componentes = Componente::select('id', 'nome AS text')->get();

        return $componentes;
    } 
}
