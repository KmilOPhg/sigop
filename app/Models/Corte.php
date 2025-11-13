<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Corte extends Model
{
    protected $table = 'cortes';
    protected $fillable = ['nombre','cant_diario','referencia_id'];

    public function referencia(): BelongsTo
    {
        return $this->belongsTo(Referencia::class, 'referencia_id');
    }
}
