<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ["nome" => "ENSINO MÉDIO INTEGRADO"],
            ["nome" => "GRADUAÇÃO"],
            ["nome" => "ESPECIALIZAÇÃO"],
            ["nome" => "MESTRADO"],
            ["nome" => "DOUTORADO"],
        ];

        DB::table('nivels')->insert($data);
    }
}
