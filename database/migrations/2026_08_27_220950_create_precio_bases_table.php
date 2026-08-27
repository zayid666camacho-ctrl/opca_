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
        Schema::create('precio_bases', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_prenda');
            $table->enum('complejidad', ['Baja', 'Media', 'Alta']);
            $table->decimal('precio');
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_bases');
    }
};
