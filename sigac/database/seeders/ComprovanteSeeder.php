<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComprovanteSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                "horas" => 20,
                "atividade" => "MATERIAL DIDÁTICO - DESENVOLVIMENTO WEB",
                "categoria_id" => 6,
                "aluno_id" => 1,
                "user_id" => 2,
            ],
        ];
        DB::table('comprovantes')->insert($data);
    }
}
