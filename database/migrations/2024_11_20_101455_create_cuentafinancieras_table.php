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
        Schema::create('cuentafinancieras', function (Blueprint $table) {
            $table->id();
            $table->string('cuenta_financiera')->unique();
            $table->dateTime('fecha_evaluacion')->nullable();
            $table->string('estado_evaluacion')->nullable();
            $table->dateTime('fecha_descuento')->nullable();
            $table->decimal('descuento', 8, 2)->default(0);
            $table->string('descuento_vigencia');
            $table->integer('ciclo')->default(0);
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('cliente_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentafinancieras');
    }
};
