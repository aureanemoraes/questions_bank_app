<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssuntosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assuntos')->insert([
            'nome' => 'Logarítimo'
        ]);
        DB::table('assuntos')->insert([
            'nome' => '1ª Guerra Mundial'
        ]);
        DB::table('assuntos')->insert([
            'nome' => 'Genética'
        ]);
        DB::table('assuntos')->insert([
            'nome' => 'Mercosul'
        ]);
        DB::table('assuntos')->insert([
            'nome' => 'Realismo'
        ]);
        DB::table('assuntos')->insert([
            'nome' => '1ª Lei de Newton'
        ]);
        DB::table('assuntos')->insert([
            'nome' => 'Ligações Químicas'
        ]);
        DB::table('assuntos')->insert([
            'nome' => 'Biografia de John Locke'
        ]);
    }
}
