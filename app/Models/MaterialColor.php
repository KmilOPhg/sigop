<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialColor extends Model
{
    protected $table = 'material_color';
    protected $fillable = ['material_id','detalle_color_id'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class, 'material_id');
    }


    public function color(): BelongsTo
    {
        return $this->belongsTo(DetalleColor::class, 'detalle_color_id');
    }
}
