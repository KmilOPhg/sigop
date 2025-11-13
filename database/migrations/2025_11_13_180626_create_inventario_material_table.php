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
        Schema::create('inventario_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bodega_id')->nullable()->constrained('bodegas');
            $table->foreignId('linea_material_id')->nullable()->constrained('linea_material');
            $table->foreignId('material_color_id')->nullable()->constrained('material_color');
            $table->float('existencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_material');
    }
};
