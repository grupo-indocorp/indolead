<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function facturadetalles()
    {
        return $this->hasMany(Facturadetalle::class);
    }

    // Relación uno a muchos inversa
    public function estadofactura()
    {
        return $this->belongsTo(Estadofactura::class);
    }

    public function cuentafinanciera()
    {
        return $this->belongsTo(Cuentafinanciera::class);
    }
}
