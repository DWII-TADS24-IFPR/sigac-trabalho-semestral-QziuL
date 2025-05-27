<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

        $data = [
            [
                "url" => "documentos/alunos/1_1712167197.pdf",
                "descricao" => "CURSO DE INGLÊS - WIZARD",
                "horas_in" => 45,
                "status" => 1,
                "comentario" => "DEFERIDO",
                "horas_out" => 45,
                "categoria_id" => 5,
                "user_id" => 2,
                "created_at" => $dateNow
            ],
            [
                "url" => "documentos/alunos/1_1712337258.pdf",
                "descricao" => "PALESTRA SOBRE ARDUINO",
                "horas_in" => 5,
                "status" => 0,
                "comentario" => NULL,
                "horas_out" => 0,
                "categoria_id" => 6,
                "user_id" => 2,
                "created_at" => $dateNow
            ],
        ];

        DB::table('documentos')->insert($data);
    }
}
