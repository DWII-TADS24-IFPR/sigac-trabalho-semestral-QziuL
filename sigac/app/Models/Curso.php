<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    use softDeletes;

    protected $table = 'cursos';

    protected $fillable = [
        'nome',
        'sigla',
        'total_horas',
        'nivel_id',
        'eixo_id'
    ];

    public function setNome($value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function setSigla($value): void
    {
        $this->attributes['sigla'] = $value;
    }

    public function setTotalHoras($value): void
    {
        $this->attributes['total_horas'] = $value;
    }

    public function setNivelId($value): void
    {
        $this->attributes['nivel_id'] = $value;
    }

    public function setEixoId($value): void
    {
        $this->attributes['eixo_id'] = $value;
    }

    public function turmas(): HasMany{
        return $this->HasMany(Turma::class);
    }

    public function alunos(): HasMany{
        return $this->HasMany(Aluno::class);
    }

    public function categorias(): HasMany{
        return $this->HasMany(Categoria::class);
    }

    public function nivel(): BelongsTo{
        return $this->belongsTo(Nivel::class);
    }

    public function eixo(): BelongsTo{
        return $this->belongsTo(Eixo::class);
    }
}
