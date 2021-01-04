<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//use App\User;

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
        'user_id',
        'aluno',
        'reposta'
    ];

    // relacionamentos
    public function autor() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function questoes()
    {
        return $this->belongsToMany('App\Models\Questao', 'questoes_caderno_questoes')->withPivot('valor')->withTimestamps()->inRandomOrder();
    }

    public function alunos()
    {
        return $this->belongsToMany('App\User', 'alunos_cadernos_questoes')->withPivot(['situacao', 'nota'])->withTimestamps();
    }

    
}
