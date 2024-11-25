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
        Schema::create('producto_venta', function (Blueprint $table) {
            $table->id();
            $table->string('producto_nombre');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->decimal('total', 8, 2); // cargo
            $table->foreignId('producto_id')->constrained();
            $table->foreignId('venta_id')->constrained();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto_venta');
    }
};
