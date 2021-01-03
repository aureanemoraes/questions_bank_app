<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class AlunosController extends Controller
{
    function opcoes() {
        $alunos = User::where('user_type', 'estudante')->get();
        return $alunos;
    }
}
