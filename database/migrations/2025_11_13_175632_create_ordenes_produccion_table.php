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
        Schema::create('ordenes_produccion', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_orden')->unique();
            $table->integer('cant_pares')->nullable();
            $table->string('referencia')->nullable();
            $table->string('vendedor', 100)->nullable();
            $table->string('cliente', 100)->nullable();
            $table->string('estado', 50)->nullable();
            $table->date('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_produccion');
    }
};
