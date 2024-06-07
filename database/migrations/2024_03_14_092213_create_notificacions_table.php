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
        Schema::create('notificacions', function (Blueprint $table) {
            $table->id();
            $table->string('asunto');
            $table->text('mensaje');
            $table->date('fecha');
            $table->time('hora', precision: 0);
            $table->foreignId('notificaciontipo_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cliente_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacions');
    }
};
