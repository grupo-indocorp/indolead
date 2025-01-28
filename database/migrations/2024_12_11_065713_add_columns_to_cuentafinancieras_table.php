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
        Schema::table('cuentafinancieras', function (Blueprint $table) {
            $table->string('ultimo_monto_factura')->default('')->after('estado_evaluacion');
            $table->string('ultimo_deuda_factura')->default('')->after('estado_evaluacion');
            $table->string('periodo')->default('')->after('estado_evaluacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentafinancieras', function (Blueprint $table) {
            //
        });
    }
};
