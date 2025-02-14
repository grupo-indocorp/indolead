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
    Schema::create('inventarios', function (Blueprint $table) {
        $table->id();
        $table->integer('codigo');
        $table->string('categoria');
        $table->string('marca');
        $table->string('serie');
        $table->string('modelo');
        $table->string('estado');
        $table->string('procesador');
        $table->string('ram');
        $table->integer('num_ram');
        $table->string('disco_duro');
        $table->string('pantalla');
        $table->string('color');
        $table->string('descripcion');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios');
    }
};
