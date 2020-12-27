<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasConhecimentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas_conhecimento')->insert([
            'nome' => 'LINGUAGENS, CÓDIGO E SUAS TECNOLOGIAS'
        ]);
        DB::table('areas_conhecimento')->insert([
            'nome' => 'CIÊNCIAS NATURAIS E SUAS TECNOLOGIAS'
        ]);
        DB::table('areas_conhecimento')->insert([
            'nome' => 'CIÊNCIAS HUMANAS E SUAS TECNOLOGIAS'
        ]);
    }
}
