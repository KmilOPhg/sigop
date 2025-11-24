<?php

namespace App\Http\Controllers;

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
    /**
     * Display a listing of the resource.
     */
    public function verBodega(Request $request, string $estado = 'activo'): View|string
    {
        try {
            $bodegas = Bodega::with('inventarios')
                ->where('estado', $estado)
                ->orderBy('created_at', 'desc')
                ->paginate(12);

            $bodegasInactivosCount = Bodega::where('estado', 'inactivo')->count();

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
                'modo'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar las bodegas: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearBodegaForm(): Factory|View|RedirectResponse
    {
        try {
            $bodega = Bodega::with('inventarios')->get();

            return view('admin.inventario.bodega.crear_bodega', compact('bodega'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al cargar el formulario: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crearBodega(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'referencia' => 'required|string|max:255|unique:bodega,referencia',
                'descripcion' => 'required|string|max:50',
                'estado' => 'nullable|string|in:activo,inactivo',
            ]);

            Bodega::create([
                'referencia' => $request->referencia,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado ?? 'activo',
            ]);

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
    public function actualizarBodega(Request $request, Bodega $bodega): RedirectResponse
    {
        try {

            DB::beginTransaction();

            $request->validate([
                'descripcion' => 'required|string|max:50',
                'estado' => 'nullable|string|in:activo,inactivo',
            ]);

            $bodega->update([
                'referencia' => $bodega->referencia,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado ?? 'activo',
            ]);

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
            return response()->json([
                'message' => 'Bodega desactivada correctamente.',
                'status' => 'success',
                'estado' => $bodega->estado,
            ], 200);

        } catch (\Exception $e) {
            //Retornar respuesta JSON de error
            Log::error('Error al desactivar la bodega: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al desactivar la bodega: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }
}
