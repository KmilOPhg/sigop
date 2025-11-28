<?php

namespace App\Http\Repositories;

use App\Models\Bodega;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BodegaRepository
{
    /**
     * @param string $estado
     * @return LengthAwarePaginator
     *
     * Repositorio para la consulta de select en bodega
     */
    public function verBodega(string $estado) : LengthAwarePaginator
    {
        return Bodega::where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }

    /**
     * @return mixed
     *
     * Conteo de inactivas
     */
    public function inactivasCount() : mixed
    {
        return Bodega::where('estado', 'inactivo')->count();
    }

    /**
     * @return Collection
     *
     * Formulario de crear bodega
     */
    public function crearBodegaForm() : Collection
    {
        return Bodega::with('inventarios')->get();
    }

    /**
     * @param $request
     * @return mixed
     *
     * Consulta de creacion de bodega
     */
    public function crearBodega($request)
    {
        return Bodega::create([
            'referencia' => $request->referencia,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado ?? 'activo',
        ]);
    }

    public function actualizarBodega($request, $bodega)
    {
        return $bodega->update([
            'referencia' => $request->referencia,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado ?? 'activo',
        ]);
    }
}
