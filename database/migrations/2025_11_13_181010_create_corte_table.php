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
        Schema::create('corte', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre',50)->nullable();
            $table->integer('cant_diario')->nullable();
            $table->foreignId('referencia_id')->constrained('referencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('corte');
    }
};
