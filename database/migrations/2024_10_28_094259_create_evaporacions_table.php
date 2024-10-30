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
            $table->string('identificacion')->nullable(); // ID
            $table->string('ruc')->nullable(); // Ruc
            $table->string('razon_social')->nullable(); // Razon Social
            $table->string('numero_servicio')->nullable(); // Numero
            $table->string('orden_pedido')->nullable(); // Orden
            $table->string('producto')->nullable(); // Producto
            $table->string('cargo_fijo')->nullable(); // Cargo Fijo
            $table->string('descuento')->nullable(); // Descuento
            $table->string('descuento_vigencia')->nullable(); // Descuento Vigencia
            $table->string('cuenta_financiera')->nullable(); // Cuenta Financiera
            $table->string('ejecutivo')->nullable(); // Ejecutivo
            $table->string('identificacion_ejecutivo')->nullable(); // Codigo
            $table->string('equipo')->nullable(); // Equipo
            $table->string('supervisor')->nullable(); // Supervisor
            $table->date('fecha_solicitud')->nullable(); // Fecha Solicitud
            $table->date('fecha_activacion')->nullable(); // Fecha Activacion
            $table->string('periodo_servicio')->nullable(); // Periodo (genera con la fecha de activacion)
            $table->date('fecha_evaluacion')->nullable(); // Fecha Evaluacion
            $table->string('estado_linea')->nullable(); // Estado
            $table->date('fecha_estado_linea')->nullable(); // Estado Fecha
            $table->string('evaluacion_descuento')->nullable(); // EvaluacionDescuento
            $table->string('evaluacion_descuento_vigencia')->nullable(); // EvaluacionDescuentoVigencia
            $table->date('fecha_evaluacion_descuento_vigencia')->nullable(); // Fecha "Fecha de EvaluacionDescuentoVigencia"
            $table->string('ciclo_factuacion')->nullable(); // Ciclo facturacion
            $table->string('estado_facturacion1')->nullable(); // 01 EstadoFacturacion
            $table->date('fecha_emision1')->nullable(); // "01 FechaEmision"
            $table->date('fecha_vencimiento1')->nullable(); // "01FechaVencimiento"
            $table->string('monto_facturado1')->nullable(); // "01MontoFacturado"
            $table->string('deuda1')->nullable(); // "01Deuda"
            $table->string('estado_facturacion2')->nullable(); // 02 EstadoFacturacio
            $table->date('fecha_emision2')->nullable(); // "02FechaEmision"
            $table->date('fecha_vencimiento2')->nullable(); // "02FechaVencimiento"
            $table->string('monto_facturado2')->nullable(); // "02MontoFacturado"
            $table->string('deuda2')->nullable(); // "02Deuda"
            $table->string('estado_facturacion3')->nullable(); // 03 EstadoFacturacion
            $table->date('fecha_emision3')->nullable(); // "03FechaEmision"
            $table->date('fecha_vencimiento3')->nullable(); // "03FechaVencimiento"
            $table->string('monto_facturado3')->nullable(); // "03MontoFacturado"
            $table->string('deuda3')->nullable(); // "03Deuda"
            $table->string('observacion')->nullable(); // Observacion
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
