<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del archivo
            $table->string('path'); // Ruta del archivo en el servidor
            $table->unsignedBigInteger('uploaded_by'); // ID del usuario que subió el archivo
            $table->string('description')->nullable(); // Descripción del archivo
            $table->string('format'); // Formato del archivo (extensión)
            $table->string('size'); // Tamaño del archivo
            $table->string('category')->nullable(); // Categoría del archivo
            $table->timestamps();

            // Clave foránea para relacionar con la tabla de usuarios
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
