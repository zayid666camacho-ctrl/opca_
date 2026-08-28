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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->date('fecha_entrega');
            $table->enum('estado', ['recibido', 'en_proceso', 'terminado', 'entregado', 'cancelado']);
            $table->string('descripcion');
            $table->decimal('precio', 10,2);
            $table->decimal('saldo_pendiente', 10,2);
            $table->foreignId('idcliente');

            $table->foreign('idcliente')->references('id')->on('clientes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
