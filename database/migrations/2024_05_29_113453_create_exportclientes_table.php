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
        Schema::create('exportclientes', function (Blueprint $table) {
            $table->id();
            $table->string('ruc');
            $table->string('razon_social');
            $table->text('ciudad');
            $table->date('fecha_creacion');
            $table->date('fecha_blindaje');
            $table->date('fecha_primer_contacto');
            $table->date('fecha_ultimo_contacto'); // Fecha de gestión
            $table->date('fecha_proximo_contacto');
            $table->text('direccion_instalacion');
            $table->string('producto'); // productos usado en secodi
            $table->string('producto_ultimo_registro');
            $table->string('producto_categoria');
            $table->string('producto_total_cantidad');
            $table->string('producto_total_precio');
            $table->string('producto_total_total');
            $table->string('producto_categoria_1'); // productos usado en indotech
            $table->string('producto_categoria_1_total');
            $table->string('producto_categoria_2');
            $table->string('producto_categoria_2_total');
            $table->string('producto_categoria_3');
            $table->string('producto_categoria_3_total');
            $table->string('producto_categoria_4');
            $table->string('producto_categoria_4_total');
            $table->text('contacto');
            $table->text('contacto_dni');
            $table->text('contacto_cargo');
            $table->text('contacto_email');
            $table->text('contacto_celular');
            $table->string('ejecutivo');
            $table->string('ejecutivo_equipo');
            $table->string('ejecutivo_sede');
            $table->string('etapa');
            $table->string('etapa_blindaje');
            $table->string('etapa_avance');
            $table->string('etapa_probabilidad');
            $table->text('comentario_5');
            $table->text('comentario_4');
            $table->text('comentario_3');
            $table->text('comentario_2');
            $table->text('comentario_1');
            $table->string('estado_wick'); // detalles adicionales
            $table->string('estado_dito');
            $table->string('lineas_claro');
            $table->string('lineas_entel');
            $table->string('lineas_bitel');
            $table->string('lineas_movistar');
            $table->string('cliente_tipo');
            $table->string('agencia');
            $table->integer('venta_id');
            $table->integer('ejecutivo_id');
            $table->integer('ejecutivo_equipo_id');
            $table->integer('ejecutivo_sede_id');
            $table->integer('etapa_id');
            $table->foreignId('cliente_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exportclientes');
    }
};
