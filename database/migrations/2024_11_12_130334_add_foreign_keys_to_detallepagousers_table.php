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
        Schema::table('detallepagousers', function (Blueprint $table) {
            $table->foreignId('contratotipo_id')->after('user_id')->nullable()->constrained();
            $table->foreignId('planillaempresa_id')->after('user_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detallepagousers', function (Blueprint $table) {
            //
        });
    }
};
