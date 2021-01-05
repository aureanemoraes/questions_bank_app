<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestoesCadernoQuestoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questoes_caderno_questoes', function (Blueprint $table) {
            $table->id();
            # questao
            $table->unsignedBigInteger('questao_id');
            $table->foreign('questao_id')->references('id')->on('questoes');
            # caderno questão
            $table->unsignedBigInteger('caderno_questao_id');
            $table->foreign('caderno_questao_id')->references('id')->on('cadernos_questoes');
            $table->float('valor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questoes_caderno_questoes');
    }
}
