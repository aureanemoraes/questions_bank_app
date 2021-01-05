<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAlunosCadernosQuestoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunos_cadernos_questoes', function (Blueprint $table) {
            $table->id();
            # aluno
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            # caderno questão
            $table->unsignedBigInteger('caderno_questao_id');
            $table->foreign('caderno_questao_id')->references('id')->on('cadernos_questoes');
            $table->string('situacao')->default('aberto'); // aberto, iniciado, finalizado
            $table->float('nota')->nullable(); // nota lançada após a situação do caderno mudar para finalizado // se o caderno for publico, somente instanciar nesta tabela, qndo o aluno finalizar o caderno.
            $table->datetime('started_at')->nullable();
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
        Schema::dropIfExists('alunos_cadernos_questoes');
    }
}
