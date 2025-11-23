<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function verBodega(): Factory|View
    {
        $users = User::with('roles', 'permissions')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearBodegaForm(): Factory|View
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crearBodega(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.listar')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editarBodega(User $user): Factory|View
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizarBodega(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'estado' => 'required|string|in:activo,inactivo',
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'estado' => $request->estado,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.listar')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function inhabilitarBodega(Request $request, User $user): JsonResponse
    {
        $bodega->update(['estado' => $request->estado]);

        return response()->json([
            'message' => 'Bodega inhabilitada correctamente.',
            'status' => 'success',
            'estado' => $bodega->estado,
        ]);
        //return redirect()->route('admin.users.listar')->with('success', 'Usuario eliminado correctamente');
    }
}
