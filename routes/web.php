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
Route::get('/empresa', [PublicControler::class, 'empresa']);

//Rutas admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    //admin/dashboard
    Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    //admin/users
    Route::resource('/users', UserController::class);
});

//Rutas editor
Route::prefix('editor')->middleware(['auth', 'role:editor'])->group(function () {
    //editor/dashboard
    Route::get('/dashboard', [HomeController::class, 'editorDashboard'])->name('editor.dashboard');
});
