<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class LineaMaterial extends Model
{
    protected $table = 'linea_material';
    protected $fillable = ['nombre','cant_diaria'];


    public function inventarios(): HasMany
    {
        return $this->hasMany(InventarioMaterial::class, 'linea_material_id');
    }
}
