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
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->text('descripcion');
            $table->decimal('precio', 10,2);

            $table->foreignId('id_pedido');
            $table->foreignId('id_precio_bases');
            $table->foreignId('id_tipo_servicios');

            $table->foreign('id_pedido')->references('id')->on('pedidos');
            $table->foreign('id_precio_bases')->references('id')->on('precio_bases');
            $table->foreign('id_tipo_servicios')->references('id')->on('tipo_servicios');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios');
    }
};
