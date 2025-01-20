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
            $table->string('text_cliente_ruc')->default('')->after('ciclo');
            $table->string('text_cliente_razon_social')->default('')->after('text_cliente_ruc');
            $table->string('text_user_nombre')->default('')->after('text_cliente_razon_social');
            $table->string('text_user_equipo')->default('')->after('text_user_nombre');
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
