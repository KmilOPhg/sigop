@extends('layouts.app')

@vite(['resources/js/dashboard.js'])

@push('styles')
<style>
    #chartBodegasEstado, #chartMaterialesEstado, #chartBodegas, #chartMateriales {
        width: 100%;
        height: 300px;
    }
</style>
@endpush

@section('content')
    <div class="page space-y-8" data-seccion="dashboard">

        {{-- Page Header --}}
        <div class="flex items-end justify-between">
            <div>
                <span class="text-xs font-bold text-primary/40 uppercase tracking-[0.2em]">Panel Principal</span>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface mt-1">Dashboard General</h2>
            </div>
            <div class="flex gap-2">
                <div class="flex items-center px-3 py-1 bg-surface-container-high rounded-full text-xs font-medium text-secondary">
                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                    Sistema Activo
                </div>
            </div>
        </div>

        {{-- Stat Cards (Bento Grid) --}}
        <div class="grid grid-cols-12 gap-6">

            {{-- Hero Card --}}
            <div class="col-span-12 lg:col-span-8 bg-surface-container-low rounded-xl p-6 relative overflow-hidden min-h-[200px]">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <span class="material-symbols-outlined text-[120px]">precision_manufacturing</span>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-1">Resumen del Sistema</h3>
                    <p class="text-lg text-slate-600 mt-2">Estado general de bodegas y materiales registrados en SIGOP.</p>
                </div>
                <div class="mt-6 grid grid-cols-4 gap-4">
                    <div class="bg-surface-container-lowest p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Bodegas Activas</p>
                        <p class="text-2xl font-bold mt-1 text-green-600" id="bodegasActivas">0</p>
                    </div>
                    <div class="bg-surface-container-lowest p-4 rounded-lg shadow-sm border-l-4 border-slate-400">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Bodegas Inactivas</p>
                        <p class="text-2xl font-bold mt-1 text-slate-500" id="bodegasInactivas">0</p>
                    </div>
                    <div class="bg-surface-container-lowest p-4 rounded-lg shadow-sm border-l-4 border-blue-600">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Mat. Activos</p>
                        <p class="text-2xl font-bold mt-1 text-blue-600" id="materialesActivos">0</p>
                    </div>
                    <div class="bg-surface-container-lowest p-4 rounded-lg shadow-sm border-l-4 border-tertiary-container">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Mat. Inactivos</p>
                        <p class="text-2xl font-bold mt-1 text-tertiary-container" id="materialesInactivos">0</p>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="col-span-12 lg:col-span-4 bg-surface-container-highest rounded-xl p-6 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-primary flex items-center">
                        <span class="material-symbols-outlined mr-2 text-lg text-secondary">bolt</span>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="space-y-3 mt-2 flex-1">
                    <a href="{{ route('admin.materiales.listar') }}" class="bg-surface-container-lowest p-3 rounded-lg flex items-center gap-3 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 rounded bg-blue-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600">category</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Gestionar Materiales</p>
                            <p class="text-[10px] text-slate-500">Ver, crear y editar materiales</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.bodegas.listar') }}" class="bg-surface-container-lowest p-3 rounded-lg flex items-center gap-3 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600">warehouse</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Gestionar Bodegas</p>
                            <p class="text-[10px] text-slate-500">Administrar ubicaciones</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.listar') }}" class="bg-surface-container-lowest p-3 rounded-lg flex items-center gap-3 hover:bg-blue-50 transition-colors group">
                        <div class="w-10 h-10 rounded bg-amber-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-600">group</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold">Gestionar Usuarios</p>
                            <p class="text-[10px] text-slate-500">Roles y permisos</p>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Charts Row 1: Pie/Donut --}}
            <div class="col-span-12 lg:col-span-6 bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Bodegas (Activas vs Inactivas)</h3>
                <div id="chartBodegasEstado"></div>
            </div>
            <div class="col-span-12 lg:col-span-6 bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Materiales (Activos vs Inactivos)</h3>
                <div id="chartMaterialesEstado"></div>
            </div>

            {{-- Charts Row 2: Bar --}}
            <div class="col-span-12 lg:col-span-6 bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Bodegas por Referencia</h3>
                <div class="overflow-x-auto">
                    <div id="chartBodegas"></div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-6 bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Materiales por Item</h3>
                <div class="overflow-x-auto">
                    <div id="chartMateriales"></div>
                </div>
            </div>
        </div>
    </div>
@endsection