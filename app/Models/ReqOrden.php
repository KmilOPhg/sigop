<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReqOrden extends Model
{
    protected $table = 'req_ordenes';
    protected $fillable = ['material_color_id','cant_material'];

    public function materialColor(): BelongsTo
    {
        return $this->belongsTo(MaterialColor::class, 'material_color_id');
    }

    public function opRequerimientos()
    {
        return $this->hasMany(OpRequerimiento::class, 'req_orden_id');
    }
}
