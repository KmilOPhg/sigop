<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        // -- Permisos de Dashboard
        Permission::create(['name' => 'ver dashboard']);
        Permission::create(['name' => 'ver reportes']);

        // -- Permisos de Usuarios
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'asignar roles']);

        // -- Permisos de Materiales
        Permission::create(['name' => 'ver materiales']);
        Permission::create(['name' => 'crear materiales']);
        Permission::create(['name' => 'editar materiales']);
        Permission::create(['name' => 'eliminar materiales']);

        // -- Permisos de Bodegas
        Permission::create(['name' => 'ver bodegas']);
        Permission::create(['name' => 'crear bodegas']);
        Permission::create(['name' => 'editar bodegas']);
        Permission::create(['name' => 'eliminar bodegas']);

        // Rol admin: Todos los permisos
        $adminRole->givePermissionTo(Permission::all());

        // Rol editor: Permisos de consulta y edición limitada
        $editorRole->givePermissionTo([
            'ver dashboard',
            'ver materiales',
            'editar materiales',
            'ver bodegas',
            'editar bodegas',
        ]);
    }
}
