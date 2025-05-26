<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use softDeletes;

    protected $table = 'permissions';
    protected $fillable = [
        'permission',
        'rosource_id',
        'role_id'
    ];

    public function setPermission($value): void
    {
        $this->attributes['permission'] = $value;
    }

    public function setResourceId($value): void
    {
        $this->attributes['resource_id'] = $value;
    }

    public function setRoleId($value): void
    {
        $this->attributes['role_id'] = $value;
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }
}
