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
        Schema::create('op_requerimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordenes_produccion_id')->constrained('ordenes_produccion');
            $table->foreignId('req_orden_id')->constrained('req_ordenes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('op_requerimientos');
    }
};
