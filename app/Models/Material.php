<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Material extends Model
{
    protected $table = 'materials';
    protected $fillable = ['nombre_material','unidad_medida'];

    public function materialColors(): HasMany
    {
        return $this->hasMany(MaterialColor::class, 'material_id');
    }
}
