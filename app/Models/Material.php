<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Material extends Model
{
    protected $table = 'materiales';

    protected $fillable = [
        'nombre_material',
        'unidad_medida',
        'estado',
        'user_id'
    ];

    public function materialColors(): HasMany
    {
        return $this->hasMany(MaterialColor::class, 'material_id');
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
