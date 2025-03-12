<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaporacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'identificacion',
        'ruc',
        'razon_social',
        'numero_servicio',
        'orden_pedido',
        'producto',
        'cargo_fijo',
        'descuento',
        'descuento_vigencia',
        'cuenta_financiera',
        'ejecutivo',
        'identificacion_ejecutivo',
        'equipo',
        'supervisor',
        'fecha_ingreso',
        'fecha_instalacion',
        'fecha_solicitud',
        'fecha_activacion',
        'periodo_servicio',
        'direccion',
        'distrito',
        'provincia',
        'departamento',
        'fecha_evaluacion',
        'estado_linea',
        'fecha_estado_linea',
        'evaluacion_descuento',
        'evaluacion_descuento_vigencia',
        'fecha_evaluacion_descuento_vigencia',
        'ciclo_factuacion',
        'estado_facturacion1',
        'fecha_emision1',
        'fecha_vencimiento1',
        'monto_facturado1',
        'deuda1',
        'monto_parcial1',
        'estado_facturacion2',
        'fecha_emision2',
        'fecha_vencimiento2',
        'monto_facturado2',
        'deuda2',
        'monto_parcial2',
        'estado_facturacion3',
        'fecha_emision3',
        'fecha_vencimiento3',
        'monto_facturado3',
        'deuda3',
        'monto_parcial3',
        'observacion',
        'deuda_total',
        'feedback',
        'estadofactura_id',
        'categoria_id',
        'sede_id',
        'cuentafinanciera_id',
        'user_evaporacion',
    ];

    // Relación uno a muchos inversa
    public function cuentafinanciera()
    {
        return $this->belongsTo(Cuentafinanciera::class);
    }
}
