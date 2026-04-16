@extends('layouts.app')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content')
    <div class="page space-y-6" data-seccion="materiales" x-data="{ showCreate: false, showEdit: false, editId: null }">

        {{-- Header --}}
        <div class="flex items-end justify-between">
            <div>
                <span class="text-xs font-bold text-primary/40 uppercase tracking-[0.2em]">Inventarios</span>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface mt-1">Gestión de Materiales</h2>
            </div>
            <div class="flex gap-3">
                @if($modo === 'activo')
                    <a href="{{ route('admin.materiales.listar', 'inactivo') }}"
                       class="ajax-load px-4 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility_off</span>
                        Ver Inactivos
                    </a>
                @else
                    <a href="{{ route('admin.materiales.listar', 'activo') }}"
                       class="ajax-load px-4 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                        Ver Activos
                    </a>
                @endif

                <button @click="showCreate = true"
                        class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Nuevo Material
                </button>
            </div>
        </div>

        @include('partials.errorsuccess')

        <div id="contenedor_tabla_materiales">
            @include('admin.inventario.componentes.componentes_material.panel_materiales_list')
        </div>

        {{-- Modal Crear Material --}}
        <div x-show="showCreate" x-transition.opacity class="fixed inset-0 z-50" style="display:none">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showCreate = false"></div>
            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-8">
                    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg z-10" @click.away="showCreate = false" x-transition.scale.95>
                <div class="px-6 py-4 border-b border-slate-200/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-on-surface">Crear Material</h3>
                        <p class="text-[10px] text-slate-400">Registra un nuevo material en el sistema</p>
                    </div>
                    <button @click="showCreate = false" class="p-1 text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
                </div>
                <form method="POST" action="{{ route('admin.materiales.crear.post') }}" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Item</label>
                        <input type="text" name="item" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nombre del material</label>
                        <input type="text" name="nombre_material" placeholder="Ej. Cordón 120cm" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unidad de medida</label>
                        <select name="unidad_medida" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                            <option value="" disabled selected>Selecciona una unidad</option>
                            @foreach(['UND','KLS','MTS','LAM','PAR','DCM','LTS','CM','RLL','GLS','LAT','LBS','BTS','MILFS','GRS','DOC','GRAM','GARR'] as $u)
                                <option value="{{ $u }}">{{ $u }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-200/50">
                        <button type="button" @click="showCreate = false" class="px-5 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-colors">Cancelar</button>
                        <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">check_circle</span> Guardar
                        </button>
                    </div>
                </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
