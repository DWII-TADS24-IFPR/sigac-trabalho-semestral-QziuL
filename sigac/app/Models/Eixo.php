<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eixo extends Model
{
    use SoftDeletes;

    protected $table = 'eixos';
    protected $fillable = ['nome'];

    public function setNome($value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function cursos(): HasMany{
        return $this->hasMany(Curso::class);
    }
}
