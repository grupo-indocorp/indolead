<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    // Relación uno a uno
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
