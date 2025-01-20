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
        Schema::table('facturadetalles', function (Blueprint $table) {
            $table->foreignId('estadoproducto_id')->after('periodo_servicio')->nullable()->constrained();
            $table->dateTime('fecha_estadoproducto')->after('periodo_servicio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facturadetalles', function (Blueprint $table) {
            //
        });
    }
};
