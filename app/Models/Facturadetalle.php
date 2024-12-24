<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturadetalle extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa
    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }

    public function estadoproducto()
    {
        return $this->belongsTo(Estadoproducto::class);
    }
}
