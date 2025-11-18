<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialValidatorRequest;
use App\Models\Material;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Factory;
use Illuminate\View\View;

class MaterialController extends Controller
{

    /**
     * @return Factory|View|RedirectResponse
     *
     * Funcion listar materiales
     */
    function listarMaterial() : Factory | View | RedirectResponse
    {
        try {
            $materiales = Material::with('user')->where('estado', 'activo')->get();

            $materialesInactivosCount = Material::where('estado', 'inactivo')->count();

            $modo = 'activo';

            return view('admin.inventario.materiales', compact('materiales', 'materialesInactivosCount', 'modo'));
        } catch (Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    function listarMaterialesInabilitados() : Factory | View | RedirectResponse
    {
        try {
            $materiales = Material::with('user')->where('estado', 'inactivo')->get();

            $materialesInactivosCount = Material::where('estado', 'inactivo')->count();

            $modo = 'inactivo';

            return view('admin.inventario.materiales', compact('materiales', 'materialesInactivosCount', 'modo'));
        } catch (Exception $e) {
            return back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * @param MaterialValidatorRequest $request
     * @return RedirectResponse
     *
     * Funcion crear material
     */
    function crearMaterial(MaterialValidatorRequest $request) : RedirectResponse
    {
        try {

            DB::beginTransaction();

            //Crear el material
            Material::create([
                'nombre_material' => $request->nombre_material,
                'unidad_medida' => $request->unidad_medida,
                'estado' => 'Activo',
                'user_id' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('admin.materiales.listar')->with('success', 'Material creado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al crear material: ' . $e->getMessage());
            return back()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * @return Factory|View|RedirectResponse Funcion mostrar formulario de crear material
     *
     * Funcion mostrar formulario de crear material
     */
    function crearMaterialForm() : Factory | View | RedirectResponse
    {
        try {
            $material = Material::with('user')->get();

            return view('admin.inventario.crear_material' , compact('material'));
        } catch (Exception $e) {
            return back()->withErrors('Error al mostrar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * @param Material $material
     * @return Factory|View|RedirectResponse
     *
     * Funcion mostrar formulario de editar material
     */
    function editarMaterial(Material $material) : Factory | View | RedirectResponse
    {
        try {
            return view('admin.inventario.editar_material', compact('material'));
        } catch (Exception $e) {
            return back()->withErrors('Error al mostrar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * @param MaterialValidatorRequest $request
     * @param Material $material
     * @return RedirectResponse
     *
     * Funcion actualizar material
     */
    function actualizarMaterial(MaterialValidatorRequest $request, Material $material) : RedirectResponse
    {
        try {
            $material->update([
                'nombre_material' => $request->nombre_material,
                'unidad_medida' => $request->unidad_medida,
                'estado' => $request->estado ? $request->estado : $material->estado,
                'user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.materiales.listar')->with('success', 'Material actualizado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors('Error al actualizar el material: ' . $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param Material $material
     * @return JsonResponse
     *
     * Funcion inhabilitar material
     */
    public function inhabilitarMaterial(Request $request, Material $material) : JsonResponse
    {
        try {
            //Obtener el estado del material desde la solicitud
            $material->update(['estado' => $request->estado]);

            //Retornar respuesta JSON de succes
            return response()->json([
                'message' => 'Material desactivado correctamente.',
                'status' => 'success',
                'estado' => $material->estado,
            ], 200);
        } catch (Exception $e) {
            //Retornar respuesta JSON de error
            Log::error('Error al desactivar el material: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al desactivar el material: ' . $e->getMessage(),
                'status' => 'error',
            ], 500);
        }
    }
}
