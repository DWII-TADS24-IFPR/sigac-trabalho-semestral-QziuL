<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Declaracao extends Model
{
    use softDeletes;

    protected $table = 'declaracoes';

    protected $fillable = [
        'hash',
        'data',
        'aluno_id',
        'comprovantes_id'
    ];

    public function setHash($value): void
    {
        $this->attributes['hash'] = $value;
    }

    public function setData($value): void
    {
        $this->attributes['data'] = $value;
    }

    public function setAlunoId($value): void
    {
        $this->attributes['aluno_id'] = $value;
    }

    public function setComprovanteId($value): void
    {
        $this->attributes['comprovante_id'] = $value;
    }

    public function aluno(): BelongsTo{
        return $this->belongsTo(Aluno::class);
    }

    public function comprovante(): BelongsTo{
        return $this->belongsTo(Comprovante::class);
    }
}
