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
        Schema::create('detallepagousers', function (Blueprint $table) {
            $table->id();
            $table->string('ruc')->default(''); // ruc
            $table->string('ruc_user')->default(''); // usuario sunat clave sol
            $table->string('ruc_password')->default(''); // contraseña sunat clave sol
            $table->string('bank_primary')->default(''); // banco principal
            $table->string('account_primary')->default(''); // cuenta principal
            $table->string('bank_optional')->default(''); // banco opcional
            $table->string('account_optional')->default(''); // cuenta opcional
            $table->decimal('salary_defined', 8, 2)->default(0); // sueldo acordado
            $table->decimal('salary_payroll', 8, 2)->default(0); // sueldo planilla
            $table->decimal('salary_receipt_honorarium', 8, 2)->default(0); // sueldo recibo por honorario
            $table->decimal('salary_movility', 8, 2)->default(0); // sueldo movilidad
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallepagousers');
    }
};
