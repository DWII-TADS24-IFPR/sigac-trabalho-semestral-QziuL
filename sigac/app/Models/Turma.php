<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turma extends Model
{
    use softDeletes;

    protected $table = 'turmas';
    protected $fillable = [
        'curso_id',
        'ano'
    ];

    public function setAno($value): void
    {
        $this->attributes['ano'] = $value;
    }

    public function setCursoId($value): void
    {
        $this->attributes['curso_id'] = $value;
    }

    public function curso(): BelongsTo{
        return $this->belongsTo(Curso::class);
    }

    public function alunos(): HasMany{
        return $this->hasMany(Aluno::class);
    }
}
