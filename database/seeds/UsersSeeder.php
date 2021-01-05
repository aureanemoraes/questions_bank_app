<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',
            'cpf' => '12345678910',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'administrador'
        ]);
        DB::table('users')->insert([
            'name' => 'Professor',
            'cpf' => '12345678911',
            'email' => 'prof@prof.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'professor'
        ]);
        DB::table('users')->insert([
            'name' => 'Estudante',
            'cpf' => '12345678912',
            'email' => 'estudante@estudante.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'estudante'
        ]);

        DB::table('users')->insert([
            'name' => 'Estudante2',
            'cpf' => '12345678913',
            'email' => 'estudante2@estudante2.com',
            'password' => Hash::make('12345678'),
            'user_type' => 'estudante'
        ]);
    }
}
