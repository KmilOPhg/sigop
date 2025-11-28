<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialValidatorRequest;
use App\Models\Material;
use App\Http\Repositories\MaterialRepository;
use App\Http\Services\MaterialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MaterialController extends Controller
{
    protected MaterialRepository $materialRepository;
    protected MaterialService $materialService;

    public function __construct(MaterialRepository $materialRepository, MaterialService $materialService)
    {
        $this->materialRepository = $materialRepository;
        $this->materialService = $materialService;
    }

    public function listarMaterial(Request $request, $estado = 'activo'): Factory|View|string|RedirectResponse
    {
        try {
            return $this->materialService->listarMaterial($estado, $request);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al listar materiales: ' . $e->getMessage()]);
        }
    }

    public function crearMaterialForm(): View|Factory|RedirectResponse
    {
        try {
            return $this->materialService->crearMaterialForm();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar el formulario: ' . $e->getMessage()]);
        }
    }

    public function crearMaterial(MaterialValidatorRequest $request): RedirectResponse
    {
        return $this->materialService->crearMaterial($request);
    }

    public function editarMaterial(Material $material): View|Factory|RedirectResponse
    {
        try {
            return view('admin.inventario.material.editar_material', compact('material'));
        } catch (\Exception $e) {
            return back()->withErrors('Error al mostrar el formulario: ' . $e->getMessage());
        }
    }

    public function actualizarMaterial(MaterialValidatorRequest $request, Material $material): RedirectResponse
    {
        return $this->materialService->actualizarMaterial($request, $material);
    }

    public function inhabilitarMaterial(Request $request, Material $material): JsonResponse
    {
        return $this->materialService->inhabilitarMaterial($request, $material);
    }
}
