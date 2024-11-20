<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
