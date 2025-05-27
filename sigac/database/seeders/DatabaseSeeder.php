<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
        $this->call(EixoSeeder::class);
        $this->call(NivelSeeder::class);
        $this->call(CursoSeeder::class);
        $this->call(TurmaSeeder::class);
        $this->call(CategoriaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DocumentoSeeder::class);
        $this->call(AlunoSeeder::class);
    }
}
