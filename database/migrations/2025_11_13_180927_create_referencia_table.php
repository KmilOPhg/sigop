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
        Schema::create('referencias', function (Blueprint $table) {
            $table->id();
            $table->integer('ref')->nullable();
            $table->boolean('cuello_botella')->default(false);
            $table->integer('cant_diario')->nullable();
            $table->foreignId('ordenes_produccion_id')->constrained('ordenes_produccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referencia');
    }
};
