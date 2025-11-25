<?php

namespace App\Http\Repositories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MaterialRepository
{
    public function listarMaterial($estado): LengthAwarePaginator
    {
        return Material::with('user')
            ->where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    public function inactivosCount()
    {
        return Material::where('estado', 'inactivo')->count();
    }

    public function crearMaterial($request)
    {
        return Material::create([
            'item_material' => $request->item,
            'nombre_material' => $request->nombre_material,
            'unidad_medida' => $request->unidad_medida,
            'estado' => 'activo',
            'user_id' => auth()->id(),
        ]);
    }

    public function crearMaterialForm(): Collection
    {
        return Material::with('user')->get();
    }

    public function actualizarMaterial($request, Material $material)
    {
        return $material->update([
            'item_material' => $material->item_material,
            'nombre_material' => $request->nombre_material,
            'unidad_medida' => $request->unidad_medida,
            'estado' => $request->estado ?? $material->estado,
            'user_id' => auth()->id(),
        ]);
    }

    public function cambiarEstadoMaterial(Material $material, $estado) : bool
    {
        return $material->update([
            'estado' => $estado
        ]);
    }
}
