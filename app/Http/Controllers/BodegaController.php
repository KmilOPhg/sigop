<?php

namespace App\Http\Controllers;

use App\Http\Repositories\BodegaRepository;
use App\Http\Requests\BodegaValidatorRequest;
use App\Http\Responses\ApiResponse;
use App\Http\Services\BodegaService;
use App\Models\Bodega;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BodegaController extends Controller
{

    protected BodegaRepository $bodegaRepository;
    protected BodegaService $bodegaService;

    public function __construct(BodegaRepository $bodegaRepository, BodegaService $bodegaService)
    {
        $this->bodegaRepository = $bodegaRepository;
        $this->bodegaService = $bodegaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function verBodega(Request $request, BodegaRepository $bodegaRepository, BodegaService $bodegaService, $estado = 'activo'): View|string
    {
        try {
            //Repositorio
            $bodegas = $bodegaRepository->verBodega($estado);
            $bodegasInactivosCount = $bodegaRepository->inactivasCount();

            //Retornar el servicio
            return $bodegaService->verBodega($estado, $request, $bodegas, $bodegasInactivosCount);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar las bodegas: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearBodegaForm(BodegaRepository $bodegaRepository): Factory|View|RedirectResponse
    {
        try {
            $bodega = $bodegaRepository->crearBodegaForm();

            return view('admin.inventario.bodega.crear_bodega', compact('bodega'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar el formulario: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crearBodega(BodegaValidatorRequest $request, BodegaRepository $bodegaRepository): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $bodegaRepository->crearBodega($request);

            DB::commit();
            return redirect()->route('admin.bodegas.listar')->with('success', 'Bodega creada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear la bodega: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editarBodega(Bodega $bodega): Factory|View|RedirectResponse
    {
        try {
            return view('admin.inventario.bodega.editar_bodega', compact('bodega'));
        } catch (\Exception $e) {
            return back()->withErrors('Error al mostrar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizarBodega(Request $request, Bodega $bodega, BodegaRepository $bodegaRepository): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $bodegaRepository->actualizarBodega($request, $bodega);

            DB::commit();
            return redirect()->route('admin.bodegas.listar')->with('success', 'Bodega actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar la bodega: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function inhabilitarBodega(Request $request, Bodega $bodega): JsonResponse
    {
        try {
            //Obtener el estado del bodega desde la solicitud
            $bodega->update(['estado' => $request->estado]);

            //Retornar respuesta JSON de succes
            return ApiResponse::success([$bodega->estado], 'Bodega desactivada correctamente.', 200);
        } catch (\Exception $e) {
            //Retornar respuesta JSON de error
            Log::error('Error al desactivar la bodega: ' . $e->getMessage());

            return ApiResponse::error('Error al desactivar la bodega: ', 500, [$e->getMessage()]);
        }
    }
}
