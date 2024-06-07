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
            $table->char('linea_movistar', 3)->default('0')->after('linea_bitel');
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
