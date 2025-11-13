<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporte extends Model
{
    protected $table = 'reportes';
    protected $fillable = ['tipo_reporte','fecha_generacion','ordenes_produccion_id','inventario_material_id','user_id'];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenProduccion::class, 'ordenes_produccion_id');
    }

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(InventarioMaterial::class, 'inventario_material_id');
    }
}
