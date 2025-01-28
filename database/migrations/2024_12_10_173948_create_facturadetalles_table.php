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
        Schema::create('facturadetalles', function (Blueprint $table) {
            $table->id();
            $table->string('numero_servicio');
            $table->string('orden_pedido');
            $table->string('producto');
            $table->decimal('cargo_fijo', 8, 2);
            $table->decimal('monto', 8, 2);
            $table->decimal('descuento', 8, 2);
            $table->string('descuento_vigencia');
            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_activacion');
            $table->string('periodo_servicio');
            $table->foreignId('factura_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturadetalles');
    }
};
