<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    // Relación uno a uno
    public function user() // jefe de equipo
    {
        return $this->belongsTo(User::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }

    // Relación uno a muchos inversa
    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    // Relación muchos a muchos
    public function users() // usersHistorial
    {
        return $this->belongsToMany(User::class)->withPivot('id')->withTimestamps();
    }
}
