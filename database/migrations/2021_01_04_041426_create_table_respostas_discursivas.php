<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRespostasDiscursivas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respostas_discursivas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->longText('texto');
            # questao
            $table->unsignedBigInteger('questao_id');
            $table->foreign('questao_id')->references('id')->on('questoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('respostas_discursivas');
    }
}
