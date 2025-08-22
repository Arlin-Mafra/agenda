<?php

namespace App\Models;

class Role extends BaseModel
{
    protected $table = 'roles';

    protected $fillable = [
        'nome', // ex: admin, profissional, cliente
        'descricao'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
