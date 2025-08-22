<?php

namespace App\Models;

class User extends BaseModel
{
    protected $table = 'users';

    protected $fillable = [
        'nome',
        'email',
        'senha_hash',
        'role_id',
        'tenant_id',
        'status',
        'ultimo_login'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
