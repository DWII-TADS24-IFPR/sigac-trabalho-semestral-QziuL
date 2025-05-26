<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use softDeletes;

    protected $table = 'resources';
    protected $fillable = ['nome'];

    public function setNome($value): void
    {
        $this->attributes['nome'] = $value;
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class);
    }
}
