<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                // ADMINISTRADOR
                "name" => "LUIZ FERNANDO QUINHOLI",
                "email" => "luiz@gmail.com",
                "password" => bcrypt('123admin123'),
                "is_admin" => true,
            ],
            [
                // ALUNO
                "name" => "TESTE",
                "email" => "teste@gmail.com",
                "password" => bcrypt('123teste123'),
                "is_admin" => false,
            ],
        ];
        DB::table('users')->insert($data);
    }
}
