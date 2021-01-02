<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadernosDeQuestoesAlunosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadernos_questoes_alunos', function (Blueprint $table) {
            $table->id();
            #cq
            $table->unsignedBigInteger('cq_id')->nullable();
            $table->foreign('cq_id')->references('id')->on('cadernos_questoes');
            # aluno
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
        Schema::dropIfExists('cadernos_questoes_alunos');
    }
}
