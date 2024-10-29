<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaporacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'Identificacion',
        'RucNumero',
        'RucRazonSocial',
        'ProductoNumero',
        'ProductoOrden',
        'ProductoNombre',
        'ProductoCargoFijo',
        'ProductoDescuento',
        'ProductoDescuentoVigencia',
        'ProductoCuentaFinanciera',
        'EjecutivoNombre',
        'EjecutivoCodigo',
        'EjecutivoEquipo',
        'EjecutivoSupervisor',
        'FechaSolicitud',
        'FechaActivacion1',
        'FechaEjecutivoPeriodo',
        'IdEvaporacion',
        'FechaActivacion2',
        'FechaEvaluacion',
        'EvaluacionEstado',
        'EvaluacionEstadoFecha',
        'EvaluacionDescuento',
        'EvaluacionDescuentoVigencia',
        'EvaluacionDescuentoFecha',
        'CicloFacturación',
        'EstadoFacturacion1',
        'FechaEmision1',
        'FechaVencimiento1',
        'MontoFacturado1',
        'Deuda1',
        'EstadoFacturacion2',
        'FechaEmision2',
        'FechaVencimiento2',
        'MontoFacturado2',
        'Deuda2',
        'EstadoFacturacion3',
        'FechaEmision3',
        'FechaVencimiento3',
        'MontoFacturado3',
        'Deuda3',
        'Observacion',
    ];
}
