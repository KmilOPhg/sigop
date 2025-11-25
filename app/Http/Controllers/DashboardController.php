<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Material;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Js;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function data()
    {
        // Bodegas agrupadas por referencia
        $bodegasPorReferencia = Bodega::selectRaw('referencia, descripcion, estado, COUNT(*) as total')
            ->groupBy('referencia', 'descripcion', 'estado')
            ->get()
            ->map(fn($b) => [
                'referencia' => $b->referencia,
                'nombre' => $b->descripcion,
                'estado' => $b->estado,
                'total' => $b->total
            ]);

        // Materiales agrupados por item
        $materialesPorItem = Material::selectRaw('item_material, nombre_material, estado, COUNT(*) as total')
            ->groupBy('item_material', 'nombre_material', 'estado')
            ->get()
            ->map(fn($m) => [
                'item' => $m->item_material,
                'nombre' => $m->nombre_material,
                'estado' => $m->estado,
                'total' => $m->total
            ]);

        // Contadores para pie/donut
        $totales = [
            'bodegas' => [
                'activas' => Bodega::where('estado', 'activo')->count(),
                'inactivas' => Bodega::where('estado', 'inactivo')->count(),
            ],
            'materiales' => [
                'activas' => Material::where('estado', 'activo')->count(),
                'inactivas' => Material::where('estado', 'inactivo')->count(),
            ]
        ];

        return response()->json([
            'bodegasReferencias' => $bodegasPorReferencia,
            'materialesItems' => $materialesPorItem,
            'totales' => $totales
        ]);
    }

    public function getBodegas($referencia) : JsonResponse
    {
        $bodegas = Bodega::where('referencia', $referencia)->get();

        return response()->json($bodegas);
    }

    public function getMateriales($item) : JsonResponse
    {
        $materiales = Material::where('item_material', $item)->get();

        return response()->json($materiales);
    }

}
