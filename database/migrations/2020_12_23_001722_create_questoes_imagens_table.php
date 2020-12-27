<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestoesImagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questoes_imagens', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            # questão
            $table->unsignedBigInteger('questao_id');
            $table->foreign('questao_id')->references('id')->on('questoes');
            # imagem
            $table->unsignedBigInteger('imagem_id');
            $table->foreign('imagem_id')->references('id')->on('imagens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questoes_imagens');
    }
}
