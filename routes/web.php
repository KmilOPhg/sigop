<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicControler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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
});

//Rutas editor
Route::prefix('editor')->name('editor.')->middleware(['auth', 'role:editor'])->group(function () {
    //editor/dashboard
    Route::get('/dashboard', [HomeController::class, 'editorDashboard'])->name('dashboard');
});
