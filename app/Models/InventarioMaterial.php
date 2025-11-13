<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarioMaterial extends Model
{
    protected $table = 'inventario_material';
    protected $fillable = ['bodega_id','linea_material_id','material_color_id','existencia'];

    public function bodega(): BelongsTo
    {
        return $this->belongsTo(Bodega::class, 'bodega_id');
    }

    public function lineaMaterial(): BelongsTo
    {
        return $this->belongsTo(LineaMaterial::class, 'linea_material_id');
    }

    public function materialColor(): BelongsTo
    {
        return $this->belongsTo(MaterialColor::class, 'material_color_id');
    }
}
