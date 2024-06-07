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
        Schema::create('movistars', function (Blueprint $table) {
            $table->id();
            $table->string('estado_wick');
            $table->char('linea_claro', 3);
            $table->char('linea_entel', 3);
            $table->char('linea_bitel', 3);
            $table->string('ejecutivo_salesforce');
            $table->string('agencia');
            $table->foreignId('clientetipo_id')->constrained();
            $table->foreignId('cliente_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movistars');
    }
};
