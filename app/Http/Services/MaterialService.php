<?php

namespace App\Http\Services;

use App\Http\Repositories\MaterialRepository;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MaterialService
{
    protected MaterialRepository $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    public function listarMaterial($estado, $request) : Factory|View|string
    {
        $materiales = $this->materialRepository->listarMaterial($estado);
        $materialesInactivosCount = $this->materialRepository->inactivosCount();
        $modo = $estado;

        if ($request->ajax()) {

            if ($request->has('page')) {
                return view('admin.inventario.componentes.componentes_material.tabla_material', compact(
                    'materiales',
                    'materialesInactivosCount',
                    'modo'
                ))->render();
            }

            return view('admin.inventario.componentes.componentes_material.header_tabla_material', compact(
                'materiales',
                'materialesInactivosCount',
                'modo'
            ))->render();
        }

        return view('admin.inventario.material.materiales', compact(
            'materiales',
            'materialesInactivosCount',
            'modo'
        ));
    }

    public function crearMaterial($request) : RedirectResponse
    {
        DB::beginTransaction();

        try {
            $this->materialRepository->crearMaterial($request);

            DB::commit();
            return redirect()->route('admin.materiales.listar')
                ->with('success', 'Material creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear material: ' . $e->getMessage());
            return back()->withErrors([$e->getMessage()]);
        }
    }

    public function crearMaterialForm() : Factory | View
    {
        $material = $this->materialRepository->crearMaterialForm();
        return view('admin.inventario.material.crear_material', compact('material'));
    }

    public function actualizarMaterial($request, $material) :RedirectResponse
    {
        try {
            $this->materialRepository->actualizarMaterial($request, $material);

            return redirect()->route('admin.materiales.listar')
                ->with('success', 'Material actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()->withErrors('Error al actualizar el material: ' . $e->getMessage());
        }
    }

    public function inhabilitarMaterial($request, $material) : JsonResponse
    {
        try {
            $this->materialRepository->cambiarEstadoMaterial($material, $request->estado);

            return ApiResponse::success([$material->estado], 'Material desactivado correctamente.', 200);

        } catch (\Exception $e) {

            Log::error('Error al desactivar material: ' . $e->getMessage());

            return ApiResponse::error('Error al desactivar material: ', 500, [$e->getMessage()]);
        }
    }
}
