<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespostaDiscursiva extends Model
{
    protected $table = 'respostas_discursivas';

    protected $fillable = ['texto', 'questao_id', 'user_id', 'caderno_questao_id'];
}
