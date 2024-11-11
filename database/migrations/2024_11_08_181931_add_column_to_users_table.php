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
            $table->string('personal_email')->default('')->after('name');
            $table->string('personal_phone')->default('')->after('name');
            $table->string('second_surname')->default('')->after('name');
            $table->string('first_surname')->default('')->after('name');
            $table->string('second_name')->default('')->after('name');
            $table->string('first_name')->default('')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'personal_email',
                'personal_phone',
                'second_surname',
                'first_surname',
                'second_name',
                'first_name',
            ]);
        });
    }
};
