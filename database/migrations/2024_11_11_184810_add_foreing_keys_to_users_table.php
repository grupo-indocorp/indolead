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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('estadouser_id')->after('tipodocumento_id')->default(1)->constrained();
            $table->foreignId('generouser_id')->after('tipodocumento_id')->default(1)->constrained();
            $table->foreignId('modalidaduser_id')->after('tipodocumento_id')->default(1)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
