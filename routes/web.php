<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\PublicControler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Laravel auth routes
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rutas publicas
Route::get('/', [PublicControler::class, 'index']);

//Rutas admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    //admin/dashboard
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('dashboard');

    //admin/users
    Route::get('/users', [UserController::class, 'verUsuarios'])->name('users.listar');
    Route::get('/users/crear', [UserController::class, 'crearUsuarosForm'])->name('users.crear.form');
    Route::post('/users', [UserController::class, 'crearUsuarios'])->name('users.guardar');
    Route::get('/users/{user}/editar', [UserController::class, 'editarUsuarios'])->name('users.editar.form');
    Route::put('/users/{user}/actualizar', [UserController::class, 'actualizarUsuarios'])->name('users.actualizar');
    Route::put('/users/{user}/desactivar', [UserController::class, 'eliminarUsuarios'])->name('users.eliminar');

    //Ruta materiales
    Route::get('/materiales/{estado?}', [MaterialController::class, 'listarMaterial'])->whereIn('estado', ['activo', 'inactivo'])->name('materiales.listar');
    //Route::get('/materiales/crear', [MaterialController::class, 'crearMaterial'])->name('materiales.crear');
    Route::get('/materiales/crear', [MaterialController::class, 'crearMaterialForm'])->name('materiales.crear.form');
    Route::post('/materiales/crear/nuevo', [MaterialController::class, 'crearMaterial'])->name('materiales.crear.post');
    Route::get('/materiales/{material}/editar', [MaterialController::class, 'editarMaterial'])->name('materiales.editar');
    Route::get('/materiales/{material}/actualizar', [MaterialController::class, 'actualizarMaterial'])->name('materiales.actualizar');
    Route::put('/materiales/{material}/inhabilitar', [MaterialController::class, 'inhabilitarMaterial'])->name('materiales.inhabilitar');
});

//Rutas editor
Route::prefix('editor')->name('editor.')->middleware(['auth', 'role:editor'])->group(function () {
    //editor/dashboard
    Route::get('/dashboard', [HomeController::class, 'editorDashboard'])->name('dashboard');
});
