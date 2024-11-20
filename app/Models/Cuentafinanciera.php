<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuentafinanciera extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_financiera',
        'fecha_evaluacion',
        'estado_evaluacion',
        'user_id',
        'equipo_id',
        'cliente_id',
    ];
}
