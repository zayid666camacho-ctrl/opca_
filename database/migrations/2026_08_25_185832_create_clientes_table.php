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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('correo');
            $table->string('telefono');
            $table->date('fecha_registro');
            $table->decimal('ancho_espalda', 5, 2)->nullable();
            $table->decimal('largo_espalda', 5, 2)->nullable();
            $table->decimal('contorno_pecho', 5, 2)->nullable();
            $table->decimal('hombro', 5, 2)->nullable();
            $table->decimal('manga', 5, 2)->nullable();
            $table->decimal('puño', 5, 2)->nullable();
            $table->decimal('antebrazo', 5, 2)->nullable();
            $table->decimal('cintura_suelta', 5, 2)->nullable();
            $table->decimal('largo_total', 5, 2)->nullable();
            $table->decimal('cintura', 5, 2)->nullable();
            $table->decimal('tiro', 5, 2)->nullable();
            $table->decimal('pierna', 5, 2)->nullable();
            $table->decimal('rodilla', 5, 2)->nullable();
            $table->decimal('largo_pierna', 5, 2)->nullable();
            $table->decimal('bota', 5, 2)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
