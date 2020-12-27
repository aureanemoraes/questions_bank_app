<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questoes', function (Blueprint $table) {
            $table->id();
            $table->longText('comando');
            $table->string('tipo_resposta');
            $table->string('nivel_dificuldade');
            # autor
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            # matriz
            $table->unsignedBigInteger('matriz_id');
            $table->foreign('matriz_id')->references('id')->on('matrizes');
            # componente
            $table->unsignedBigInteger('componente_id');
            $table->foreign('componente_id')->references('id')->on('componentes');
            # assunto
            $table->unsignedBigInteger('assunto_id');
            $table->foreign('assunto_id')->references('id')->on('assuntos');
            # area_conhecimento
            $table->unsignedBigInteger('area_conhecimento_id');
            $table->foreign('area_conhecimento_id')->references('id')->on('areas_conhecimento');
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
        Schema::dropIfExists('questoes');
    }
}
