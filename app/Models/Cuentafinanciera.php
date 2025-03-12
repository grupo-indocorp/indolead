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
        'periodo',
        'ultimo_deuda_factura',
        'ultimo_monto_factura',
        'fecha_descuento',
        'descuento',
        'descuento_vigencia',
        'backoffice_descuento',
        'backoffice_descuento_vigencia',
        'ciclo',
        'text_cliente_ruc',
        'text_cliente_razon_social',
        'text_user_nombre',
        'text_user_equipo',
        'ultimo_comentario',
        'user_id',
        'cliente_id',
        'estadofactura_id',
        'categoria_id',
        'user_evaporacion',
    ];

    // Relación uno a muchos inversa
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userEvaporacion()
    {
        return $this->belongsTo(User::class, 'user_evaporacion');
    }

    public function estadofactura()
    {
        return $this->belongsTo(Estadofactura::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
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

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
