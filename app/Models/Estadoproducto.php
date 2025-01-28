<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadoproducto extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function facturadetalles()
    {
        return $this->hasMany(Facturadetalle::class);
    }
}
