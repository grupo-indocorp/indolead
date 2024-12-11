<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Relación uno a muchos inversa
    public function estadofactura()
    {
        return $this->belongsTo(Estadofactura::class);
    }
}
