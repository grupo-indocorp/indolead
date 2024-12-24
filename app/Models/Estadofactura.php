<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadofactura extends Model
{
    use HasFactory;

    // Relación uno a muchos
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    // Relación uno a uno
    public function cuentafinancieras()
    {
        return $this->hasMany(Cuentafinanciera::class);
    }
}
