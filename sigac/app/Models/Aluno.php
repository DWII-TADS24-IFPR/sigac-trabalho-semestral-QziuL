<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aluno extends Model
{
    use softDeletes;

    protected $table = 'alunos';

    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'senha',
        'turma_id',
        'curso_id',
        'user_id',
    ];

    public function setNome($value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function setEmail($value): void
    {
        $this->attributes['email'] = $value;
    }

    public function setCpf($value): void
    {
        $this->attributes['cpf'] = $value;
    }

    public function setSenha($value): void
    {
        $this->attributes['senha'] = $value;
    }

    public function setTurmaId($value): void
    {
        $this->attributes['turma_id'] = $value;
    }

    public function setCursoId($value): void
    {
        $this->attributes['curso_id'] = $value;
    }

    public function setUserId($value): void
    {
        $this->attributes['user_id'] = $value;
    }

    public function comprovantes(): HasMany{
        return $this->hasMany(Comprovante::class);
    }

    public function turma(): BelongsTo{
        return $this->belongsTo(Turma::class);
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function curso(): BelongsTo{
        return $this->belongsTo(Curso::class);
    }
}
