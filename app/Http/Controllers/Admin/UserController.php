<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function verUsuarios(): Factory|View
    {
        $users = User::with('roles', 'permissions')->where('estado', 'activo')->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function crearUsuarosForm(): Factory|View
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.user.create', compact('roles', 'permissions'));
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
        $permissions = Permission::all();

        return view('admin.user.edit', compact('user', 'roles', 'permissions'));
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
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->roles ?? []);
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.listar')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function eliminarUsuarios(User $user): RedirectResponse
    {
        $user->update(['estado' => 'inactivo']);
        return redirect()->route('admin.users.listar')->with('success', 'Usuario eliminado correctamente');
    }
}
