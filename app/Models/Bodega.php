<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Bodega extends Model
{
    protected $table = 'bodega';

    protected $fillable = [
        'descripcion',
        'referencia',
        'estado'
    ];


    public function inventarios(): HasMany
    {
        return $this->hasMany(InventarioMaterial::class, 'bodega_id');
    }
}
