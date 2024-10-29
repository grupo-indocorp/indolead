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
            $table->string('RucNumero')->nullable();
            $table->string('RucRazonSocial')->nullable();
            $table->string('ProductoNumero')->nullable();
            $table->string('ProductoOrden')->nullable();
            $table->string('ProductoNombre')->nullable();
            $table->string('ProductoCargoFijo')->nullable();
            $table->string('ProductoDescuento')->nullable();
            $table->string('ProductoDescuentoVigencia')->nullable();
            $table->string('ProductoCuentaFinanciera')->nullable();
            $table->string('EjecutivoNombre')->nullable();
            $table->string('EjecutivoCodigo')->nullable();
            $table->string('EjecutivoEquipo')->nullable();
            $table->string('EjecutivoSupervisor')->nullable();
            $table->date('FechaSolicitud')->nullable();
            $table->date('FechaActivacion1')->nullable();
            $table->string('FechaEjecutivoPeriodo')->nullable();
            $table->string('IdEvaporacion')->nullable();
            $table->date('FechaActivacion2')->nullable();
            $table->date('FechaEvaluacion')->nullable();
            $table->string('EvaluacionEstado')->nullable();
            $table->date('EvaluacionEstadoFecha')->nullable();
            $table->string('EvaluacionDescuento')->nullable();
            $table->string('EvaluacionDescuentoVigencia')->nullable();
            $table->string('EvaluacionDescuentoFecha')->nullable();
            $table->string('CicloFacturación')->nullable();
            $table->string('EstadoFacturacion1')->nullable();
            $table->date('FechaEmision1')->nullable();
            $table->date('FechaVencimiento1')->nullable();
            $table->string('MontoFacturado1')->nullable();
            $table->string('Deuda1')->nullable();
            $table->string('EstadoFacturacion2')->nullable();
            $table->date('FechaEmision2')->nullable();
            $table->date('FechaVencimiento2')->nullable();
            $table->string('MontoFacturado2')->nullable();
            $table->string('Deuda2')->nullable();
            $table->string('EstadoFacturacion3')->nullable();
            $table->date('FechaEmision3')->nullable();
            $table->date('FechaVencimiento3')->nullable();
            $table->string('MontoFacturado3')->nullable();
            $table->string('Deuda3')->nullable();
            $table->string('Observacion')->nullable();
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
