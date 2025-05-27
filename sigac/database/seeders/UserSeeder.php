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
                "name" => "LUIZ ADMIN",
                "email" => "luiz.admin@gmail.com",
                "password" => bcrypt('123admin123'),
                "is_admin" => true,
            ],
            [
                // ALUNO
                "name" => "LUIZ ALUNO",
                "email" => "luiz.aluno@gmail.com",
                "password" => bcrypt('123luiz123'),
                "is_admin" => false,
            ],
        ];
        DB::table('users')->insert($data);
    }
}
