<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function clientesSolo() // cambiar a clientes
    {
        return $this->hasMany(Cliente::class);
    }

    // Relación muchos a muchos
    public function clientes() // cambiar a clientesHistorial
    {
        return $this->belongsToMany(Cliente::class)->withPivot('id')->withTimestamps();
    }
}
