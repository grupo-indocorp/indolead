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
            // $table->text('ultimo_comentario')->after('text_user_equipo')->change();

            $table->foreignId('categoria_id')->after('estadofactura_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentafinancieras', function (Blueprint $table) {
            // $table->text('ultimo_comentario')->after('updated_at')->change();

            $table->dropForeign(['categoria_id']);
            $table->dropColumn('categoria_id');
        });
    }
};
