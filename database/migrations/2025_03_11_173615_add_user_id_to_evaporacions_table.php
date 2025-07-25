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
        Schema::table('evaporacions', function (Blueprint $table) {
            $table->foreignId('user_evaporacion')->after('sede_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaporacions', function (Blueprint $table) {
            $table->dropForeign(['user_evaporacion']);
            $table->dropColumn('user_evaporacion');
        });
    }
};
