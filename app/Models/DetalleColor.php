<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetalleColor extends Model
{
    protected $table = 'detalle_color';
    protected $fillable = ['nombre_color'];

    public function materialColors(): HasMany
    {
        return $this->hasMany(MaterialColor::class, 'detalle_color_id');
    }
}
