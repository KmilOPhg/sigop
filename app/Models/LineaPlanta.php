<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LineaPlanta extends Model
{
    protected $table = 'linea_planta';
    protected $fillable = ['nombre','cant_diario','ordenes_produccion_id'];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenProduccion::class, 'ordenes_produccion_id');
    }
}
