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
        Schema::create('bodega', function (Blueprint $table)
        {
            $table->id(); //BIGINT(20), INDEX, AUTOINCREMENT, UNIQUE, PK
            $table->string('referencia')->unique(); // UNIQUE, INDEX
            $table->string('descripcion', 50)->nullable();
            $table->string('estado', 50)->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodega');
    }
};
