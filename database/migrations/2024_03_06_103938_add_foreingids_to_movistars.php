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
        Schema::table('movistars', function (Blueprint $table) {
            $table->foreignId('estadodito_id')->after('ejecutivo_salesforce')->constrained();
            $table->foreignId('estadowick_id')->after('ejecutivo_salesforce')->constrained();
            $table->foreignId('agencia_id')->after('clientetipo_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movistars', function (Blueprint $table) {
            //
        });
    }
};
