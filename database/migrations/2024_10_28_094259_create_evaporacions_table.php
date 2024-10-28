<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaporacions', function (Blueprint $table) {
            $table->id();
            $table->string('Identificacion');
            $table->string('RucNumero');
            $table->string('RucRazonSocial');
            $table->string('ProductoNumero');
            $table->string('ProductoOrden');
            $table->string('ProductoNombre');
            $table->string('ProductoCargoFijo');
            $table->string('ProductoDescuento');
            $table->string('ProductoDescuentoVigencia');
            $table->string('ProductoCuentaFinanciera');
            $table->string('EjecutivoNombre');
            $table->string('EjecutivoCodigo');
            $table->string('EjecutivoEquipo');
            $table->string('EjecutivoSupervisor');
            $table->string('FechaSolicitud');
            $table->string('FechaActivacion1');
            $table->string('FechaEjecutivoPeriodo');
            $table->string('IdEvaporacion');
            $table->string('FechaActivacion2');
            $table->string('FechaEvaluacion');
            $table->string('EvaluacionEstado');
            $table->string('EvaluacionEstadoFecha');
            $table->string('EvaluacionDescuento');
            $table->string('EvaluacionDescuentoVigencia');
            $table->string('EvaluacionDescuentoFecha');
            $table->string('CicloFacturación');
            $table->string('EstadoFacturacion1');
            $table->string('FechaEmision1');
            $table->string('FechaVencimiento1');
            $table->string('MontoFacturado1');
            $table->string('Deuda1');
            $table->string('EstadoFacturacion2');
            $table->string('FechaEmision2');
            $table->string('FechaVencimiento2');
            $table->string('MontoFacturado2');
            $table->string('Deuda2');
            $table->string('EstadoFacturacion3');
            $table->string('FechaEmision3');
            $table->string('FechaVencimiento3');
            $table->string('MontoFacturado3');
            $table->string('Deuda3');
            $table->string('Observacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaporacions');
    }
};
