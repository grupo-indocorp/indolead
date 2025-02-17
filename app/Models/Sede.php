<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function equipos()
    {
        return $this->hasMany(Equipo::class);
    }

    public function clientes()
    {
        return $this->hasMany(Equipo::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
