<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CadernoQuestao extends Model
{
    protected $table = 'cadernos_questoes';

    protected $fillable = [
        'titulo',
        'informacoes_adicionais',
        'data_inicial',
        'data_final',
        'duracao',
        'quantidade_questoes',
        'nota_maxima',
        'tipo',
        'categoria',
        'privacidade',
        'cq_enem_id',
        'user_id'
    ];

    // relacionamentos
    public function questoes()
    {
        return $this->belongsToMany('App\Models\Questao', 'questoes_caderno_questoes');
    }
}
