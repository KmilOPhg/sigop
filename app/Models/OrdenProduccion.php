<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccion extends Model
{
    //Modelo OrdenProduccion
    protected $table = 'ordenes_produccion';
    protected $fillable = ['cant_pares', 'vendedor', 'cliente', 'fecha_entrega'];

    public function referencias() {
        return $this->hasMany(Referencia::class, 'ordenes_produccion_op');
    }

    public function lineas() {
        return $this->hasMany(LineaPlanta::class, 'ordenes_produccion_op');
    }

    public function secciones() {
        return $this->hasMany(Seccion::class, 'ordenes_produccion_op');
    }

    public function reportes() {
        return $this->hasMany(Reporte::class, 'ordenes_produccion_op');
    }
}
