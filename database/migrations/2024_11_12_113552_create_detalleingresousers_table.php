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
        Schema::create('detalleingresousers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_entry', 0);  // fecha de ingreso
            $table->dateTime('date_termination', 0);  // fecha de cese
            $table->string('condition')->default('');  // condición
            $table->string('additional_condition')->default('');  // condición adicional
            $table->text('history');  // histórico
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleingresousers');
    }
};
