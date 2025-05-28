<?php

use App\Http\Controllers\AlunoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComprovanteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DeclaracaoController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\NivelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SolicitacaoHorasController;
use App\Http\Controllers\TurmaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home')->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
//
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('aluno', AlunoController::class);
Route::resource('categoria', CategoriaController::class);
Route::resource('comprovante', ComprovanteController::class);
Route::resource('curso', CursoController::class);
Route::resource('declaracao', DeclaracaoController::class);
Route::resource('documento', DocumentoController::class);
Route::resource('nivel', NivelController::class);
Route::resource('turma', TurmaController::class);
Route::resource('solicitacao', SolicitacaoHorasController::class);

require __DIR__.'/auth.php';
