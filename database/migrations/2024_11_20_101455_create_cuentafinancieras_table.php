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
            $table->string('cuenta_financiera');
            $table->datetime('fecha_evaluacion');
            $table->string('estado_evaluacion');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('equipo_id')->nullable()->constrained();
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
