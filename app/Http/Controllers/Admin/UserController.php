<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Agrupa los permisos por módulo basándose en la última palabra del nombre.
     */
    private function permisosAgrupados(): array
    {
        $grupos = [
            'Dashboard' => ['dashboard', 'reportes'],
            'Usuarios'  => ['usuarios', 'roles'],
            'Materiales' => ['materiales'],
            'Bodegas'   => ['bodegas'],
        ];

        $permissions = Permission::all();
        $agrupados = [];

        foreach ($grupos as $grupo => $keywords) {
            $agrupados[$grupo] = $permissions->filter(function ($p) use ($keywords) {
                foreach ($keywords as $kw) {
                    if (str_contains($p->name, $kw)) return true;
                }
                return false;
            })->values();
        }

        // Permisos que no encajen en ningún grupo
        $asignados = collect($agrupados)->flatten()->pluck('id');
        $otros = $permissions->whereNotIn('id', $asignados);
        if ($otros->isNotEmpty()) {
            $agrupados['Otros'] = $otros->values();
        }

        return $agrupados;
    }

    /**
     * Display a listing of the resource.
     */
    public function verUsuarios(): Factory|View
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permisosAgrupados = $this->permisosAgrupados();
        return view('admin.user.index', compact('users', 'roles', 'permisosAgrupados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearUsuarosForm(): Factory|View
    {
        $roles = Role::all();
        $permisosAgrupados = $this->permisosAgrupados();

        return view('admin.user.create', compact('roles', 'permisosAgrupados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function crearUsuarios(Request $request): RedirectResponse
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
    public function editarUsuarios(User $user): Factory|View
    {
        $roles = Role::all();
        $permisosAgrupados = $this->permisosAgrupados();

        return view('admin.user.edit', compact('user', 'roles', 'permisosAgrupados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function actualizarUsuarios(Request $request, User $user): RedirectResponse
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
    public function eliminarUsuarios(Request $request, User $user): JsonResponse
    {
        $user->update(['estado' => $request->estado]);

        return response()->json([
            'message' => 'Usuario desactivado correctamente.',
            'status' => 'success',
            'estado' => $user->estado,
        ]);
        //return redirect()->route('admin.users.listar')->with('success', 'Usuario eliminado correctamente');
    }
}
