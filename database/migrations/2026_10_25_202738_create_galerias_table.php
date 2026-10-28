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
        Schema::create('galerias', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->string('imagen'); // Ruta relativa en storage (Opción 1)
        $table->string('categoria')->nullable(); // Vestidos, Pantalones, Arreglos, etc.
        $table->timestamp('fecha')->useCurrent(); // Como en tu diagrama
        $table->string('realizado_por')->default('Creaciones Nayja');
        $table->boolean('visible_publico')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galerias');
    }
};
