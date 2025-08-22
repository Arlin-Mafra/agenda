<?php

namespace App\Models;

class Tenant extends BaseModel
{
    protected $table = 'tenants';

    protected $fillable = [
        'nome_empresa',
        'plano',
        'status'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
