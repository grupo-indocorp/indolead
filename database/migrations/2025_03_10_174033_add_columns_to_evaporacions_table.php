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
            $table->date('fecha_ingreso')->nullable()->after('supervisor');
            $table->date('fecha_instalacion')->nullable()->after('fecha_ingreso');
            $table->string('direccion')->nullable()->after('periodo_servicio');
            $table->string('distrito')->nullable()->after('direccion');
            $table->string('provincia')->nullable()->after('distrito');
            $table->string('departamento')->nullable()->after('provincia');
            $table->string('monto_parcial1')->nullable()->after('deuda1');
            $table->string('monto_parcial2')->nullable()->after('deuda2');
            $table->string('monto_parcial3')->nullable()->after('deuda3');
            $table->string('deuda_total')->nullable()->after('observacion');
            $table->string('feedback')->nullable()->after('deuda_total');

            $table->text('observacion')->change();

            $table->foreignId('categoria_id')->after('estadofactura_id')->nullable()->constrained();
            $table->foreignId('sede_id')->after('categoria_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaporacions', function (Blueprint $table) {
            $table->dropColumn('fecha_ingreso');
            $table->dropColumn('fecha_instalacion');
            $table->dropColumn('direccion');
            $table->dropColumn('distrito');
            $table->dropColumn('provincia');
            $table->dropColumn('departamento');
            $table->dropColumn('monto_parcial1');
            $table->dropColumn('monto_parcial2');
            $table->dropColumn('monto_parcial3');
            $table->dropColumn('deuda_total');
            $table->dropColumn('feedback');

            $table->string('observacion')->change();

            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['sede_id']);
            $table->dropColumn('categoria_id');
            $table->dropColumn('sede_id');
        });
    }
};
