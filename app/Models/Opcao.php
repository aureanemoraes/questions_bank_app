<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{
    protected $table = 'opcoes';
    protected $fillable = ['texto', 'correta', 'questao_id', 'imagem', 'nova_opcao', 'nova_opcao_imagem'];
}
