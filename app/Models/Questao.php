<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model
{
    protected $table = 'questoes';

    protected $fillable = ['comando', 'tipo_resposta', 'nivel_dificuldade', 'matriz_id', 'componente_id', 'assunto_id', 'imagens', 'user_id', 'area_conhecimento_id', 'opcoes'];

    // relacionamentos
    public function cadernos_questoes()
    {
        return $this->belongsToMany('App\Models\CadernoQuestao', 'questoes_caderno_questoes')->withPivot('valor')->withTimestamps();;
    }

    public function autor()
    {
        return $this->belongsTo('App\User');
    }
    

    public function opcoes()
    {
        return $this->hasMany('App\Models\Opcao')->inRandomOrder();
    }
    
    public function imagens()
    {
        return $this->hasMany('App\Models\Imagem');
    }

    public function matriz()
    {
        return $this->belongsTo('App\Models\Matriz');
    }

    public function componente()
    {
        return $this->belongsTo('App\Models\Componente');
    }

    public function assunto()
    {
        return $this->belongsTo('App\Models\Assunto');
    }

    public function area_conhecimento()
    {
        return $this->belongsTo('App\Models\AreaConhecimento');
    }

    
    

}
