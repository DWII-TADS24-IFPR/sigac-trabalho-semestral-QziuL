<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'curso_id',
        'maximo_horas'
    ];

    public function setNome($value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function setCursoId($value): void
    {
        $this->attributes['curso_id'] = $value;
    }

    public function setMaximoHoras($value): void
    {
        $this->attributes['maximo_horas'] = $value;
    }

    public function comprovantes(): HasMany{
        return $this->hasMany(Comprovante::class);
    }

    public function documentos(): HasMany{
        return $this->hasMany(Documento::class);
    }

    public function curso(): BelongsTo{
        return $this->belongsTo(Curso::class);
    }
}
