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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_emision');
            $table->dateTime('fecha_vencimiento');
            $table->decimal('monto', 8, 2)->default(0);
            $table->decimal('deuda', 8, 2)->default(0);
            $table->foreignId('estadofactura_id')->constrained();
            $table->foreignId('cuentafinanciera_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
