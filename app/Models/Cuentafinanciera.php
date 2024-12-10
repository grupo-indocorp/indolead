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
        'fecha_descuento',
        'backoffice_descuento',
        'backoffice_descuento_vigencia',
        'descuento',
        'descuento_vigencia',
        'ciclo',
        'user_id',
        'equipo_id',
        'cliente_id',
    ];

    // Relación uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación uno a muchos
    public function evaporacions()
    {
        return $this->hasMany(Evaporacion::class);
    }

    public function comentariocfs()
    {
        return $this->hasMany(Comentariocf::class);
    }
}
