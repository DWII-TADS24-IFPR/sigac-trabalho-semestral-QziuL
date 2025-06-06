<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EixoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ["nome" => "INFORMAÇÃO E COMUNICAÇÃO"],
            ["nome" => "RECURSOS NATURAIS"],
            ["nome" => "CIÊNCIAS HUMANAS"],
            ["nome" => "FÍSICA"],
            ["nome" => "MECÂNICA"],
            ["nome" => "LINGUAGENS"],
        ];
        DB::table('eixos')->insert($data);
    }
}
