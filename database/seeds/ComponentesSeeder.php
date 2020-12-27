<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('componentes')->insert([
            'nome' => 'Língua Portuguesa e Literatura'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Arte'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Educação Física'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Matemática'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Física'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Química'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Biologia'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'História'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Geografia'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Filosofia'
        ]);
        DB::table('componentes')->insert([
            'nome' => 'Sociologia'
        ]);
    }
}
