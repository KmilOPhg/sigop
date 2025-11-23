<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenProduccion extends Model
{
    protected $table = 'ordenes_produccion';
    protected $fillable = [
        'cant_pares',
        'numero_orden',
        'vendedor',
        'cliente',
        'fecha_entrega'
    ];


    public function opRequerimientos(): HasMany
    {
        return $this->hasMany(OpRequerimiento::class, 'ordenes_produccion_id');
    }


    public function reqOrdenes(): BelongsToMany
    {
        return $this->belongsToMany(ReqOrden::class, 'op_requerimientos', 'ordenes_produccion_id', 'req_orden_id');
    }


    public function referencias(): HasMany
    {
        return $this->hasMany(Referencia::class, 'ordenes_produccion_id');
    }


    public function lineaPlantas(): HasMany
    {
        return $this->hasMany(LineaPlanta::class, 'ordenes_produccion_id');
    }


    public function secciones(): HasMany
    {
        return $this->hasMany(Seccion::class, 'ordenes_produccion_id');
    }
}
