<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpRequerimiento extends Model
{
    protected $table = 'op_requerimientos';
    protected $fillable = ['ordenes_produccion_id','req_orden_id'];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenProduccion::class, 'ordenes_produccion_id');
    }

    public function reqOrden(): BelongsTo
    {
        return $this->belongsTo(ReqOrden::class, 'req_orden_id');
    }
}
