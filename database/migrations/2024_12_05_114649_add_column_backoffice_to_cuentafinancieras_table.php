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
            $table->string('backoffice_descuento_vigencia')->default('')->after('descuento_vigencia');
            $table->decimal('backoffice_descuento', 8, 2)->default(0)->after('descuento_vigencia');
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
