<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatrizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('matrizes')->insert([
            'nome' => 'Ensino Médio - 1ª SÉRIE'
        ]);
        DB::table('matrizes')->insert([
            'nome' => 'Ensino Médio - 2ª SÉRIE'
        ]);
        DB::table('matrizes')->insert([
            'nome' => 'Ensino Médio - 3ª SÉRIE'
        ]);
    }
}
