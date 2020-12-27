<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpcoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('opcoes', function (Blueprint $table) {
            $table->id();
            $table->longText('texto');
            # questão
            $table->unsignedBigInteger('questao_id');
            $table->foreign('questao_id')->references('id')->on('questoes');
            $table->boolean('correta')->default(false);
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
        Schema::dropIfExists('opcoes');
    }
}
