<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Referencia extends Model
{
    protected $table = 'referencias';
    protected $fillable = ['ref','cuello_botella','cant_diario','ordenes_produccion_id', 'user_id'];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenProduccion::class, 'ordenes_produccion_id');
    }

    public function cortes(): HasMany
    {
        return $this->hasMany(Corte::class, 'referencia_id');
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
