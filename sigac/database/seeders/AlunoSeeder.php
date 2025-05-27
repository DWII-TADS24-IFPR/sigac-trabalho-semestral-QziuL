<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlunoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "nome" => "LUIZ ALUNO",
                "cpf" => "00000000001",
                "email" => "luiz.aluno@gmail.com",
                "senha" => bcrypt('123luiz123'),
                "user_id" => 2,
                "curso_id" => 2,
                "turma_id" => 1,
            ],
        ];
        DB::table('alunos')->insert($data);
    }
}
