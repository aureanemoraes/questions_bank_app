<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    protected $table = 'componentes';

    protected $fillable = ['nome'];
}
