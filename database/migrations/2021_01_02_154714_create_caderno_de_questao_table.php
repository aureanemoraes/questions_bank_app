<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadernoDeQuestaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadernos_questoes', function (Blueprint $table) {
            $table->id();
            $table->text('titulo');
            $table->longText('informacoes_adicionais')->nullable();
            $table->date('data_inicial');
            $table->date('data_final');
            $table->time('duracao');
            $table->integer('quantidade_questoes');
            $table->float('nota_maxima');
            $table->string('tipo'); // PROVA OU SIMULADO
            $table->string('categoria'); // ENEM ou EJA
            $table->string('privacidade'); // PÚBLICO OU RESTRITO
            # autor
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('cadernos_questoes');
    }
}
