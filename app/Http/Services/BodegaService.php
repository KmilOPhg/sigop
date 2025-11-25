<?php

namespace App\Http\Services;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\Factory;

class BodegaService
{
    public function verBodega($estado, $request, $bodegas, $bodegasInactivosCount): Factory|View|string
    {
        $modo = $estado; // activo o inactivo

        Log::info("Listando bodegas con modo: $modo");

        if ($request->ajax()) {

            //Si es paginacion
            if ($request->has('page')) {
                return view('admin.inventario.componentes.componentes_bodegas.tabla_bodega', compact(
                    'bodegas',
                    'bodegasInactivosCount',
                    'modo'
                ))->render();
            }

            //Si no, entonces trae los activos o inactivos
            return view('admin.inventario.componentes.componentes_bodegas.header_tabla_bodegas', compact(
                'bodegas',
                'bodegasInactivosCount',
                'modo'
            ))->render();
        }

        return view('admin.inventario.bodega.bodegas', compact(
            'bodegas',
            'bodegasInactivosCount',
            'modo'
        ));
    }
}
