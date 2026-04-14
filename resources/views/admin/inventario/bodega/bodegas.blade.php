@extends('layouts.app')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content')
    <div class="page space-y-6" data-seccion="bodegas" x-data="{ showCreate: false, showEdit: false, editId: null }">

        {{-- Header --}}
        <div class="flex items-end justify-between">
            <div>
                <span class="text-xs font-bold text-primary/40 uppercase tracking-[0.2em]">Inventarios</span>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface mt-1">Gestión de Bodegas</h2>
            </div>
            <div class="flex gap-3">
                @if($modo === 'activo')
                    <a href="{{ route('admin.bodegas.listar', 'inactivo') }}"
                       class="ajax-load px-4 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility_off</span>
                        Ver Inactivas
                    </a>
                @else
                    <a href="{{ route('admin.bodegas.listar', 'activo') }}"
                       class="ajax-load px-4 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest flex items-center gap-2 hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                        Ver Activas
                    </a>
                @endif

                <button @click="showCreate = true"
                        class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Nueva Bodega
                </button>
            </div>
        </div>

        @include('partials.errorsuccess')

        {{-- Table --}}
        <div class="bg-surface-container-low rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-surface-container-high/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Código</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Descripción</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Estado</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter text-right">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/40">
                    @forelse ($bodegas as $bodega)
                        <tr class="hover:bg-surface-container-lowest transition-colors {{ $bodega->estado === 'inactivo' ? 'opacity-50' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-sm">warehouse</span>
                                    <span class="text-xs font-bold text-primary">{{ $bodega->referencia }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5"><span class="text-xs font-semibold">{{ $bodega->descripcion }}</span></td>
                            <td class="px-6 py-5">
                                <button class="toggleEstadoBtn px-2 py-1 text-[10px] font-bold rounded {{ $bodega->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                        data-id="{{ $bodega->id }}" data-estado="{{ $bodega->estado === 'activo' ? 'inactivo' : 'activo' }}">
                                    {{ ucfirst($bodega->estado) }}
                                </button>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <button @click="editId = {{ $bodega->id }}; showEdit = true"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-surface-container-high text-primary text-[10px] font-bold uppercase tracking-widest rounded hover:bg-blue-50 transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-3xl mb-2 block">inbox</span>
                                No hay bodegas registradas.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($bodegas->hasPages())
                <div class="px-6 py-4 border-t border-slate-200/40">{{ $bodegas->links() }}</div>
            @endif
        </div>

        {{-- Modal Crear Bodega --}}
        <div x-show="showCreate" x-transition.opacity class="fixed inset-0 z-50" style="display:none">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showCreate = false"></div>
            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-8">
                    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg z-10" @click.away="showCreate = false" x-transition.scale.95>
                <div class="px-6 py-4 border-b border-slate-200/50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-on-surface">Crear Bodega</h3>
                        <p class="text-[10px] text-slate-400">Registra una nueva bodega en SIGOP</p>
                    </div>
                    <button @click="showCreate = false" class="p-1 text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
                </div>
                <form method="POST" action="{{ route('admin.bodegas.crear.post') }}" class="p-6 space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Código</label>
                        <input type="text" name="referencia" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Descripción</label>
                        <input type="text" name="descripcion" placeholder="Materiales de baja rotación" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
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

        {{-- Modales Editar Bodega --}}
        @foreach($bodegas as $bodega)
            <div x-show="showEdit && editId === {{ $bodega->id }}" x-transition.opacity class="fixed inset-0 z-50" style="display:none">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showEdit = false"></div>
                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-8">
                        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg z-10" x-transition.scale.95>
                    <div class="px-6 py-4 border-b border-slate-200/50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-on-surface">Editar Bodega</h3>
                            <p class="text-[10px] text-slate-400">{{ $bodega->referencia }} &mdash; {{ $bodega->descripcion }}</p>
                        </div>
                        <button @click="showEdit = false" class="p-1 text-slate-400 hover:text-slate-600"><span class="material-symbols-outlined">close</span></button>
                    </div>
                    <form action="{{ route('admin.bodegas.actualizar', $bodega) }}" method="POST" class="p-6 space-y-5">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Código</label>
                            <input type="text" name="referencia" value="{{ $bodega->referencia }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Descripción</label>
                            <input type="text" name="descripcion" value="{{ $bodega->descripcion }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-slate-200/50">
                            <button type="button" @click="showEdit = false" class="px-5 py-2.5 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-colors">Cancelar</button>
                            <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">check_circle</span> Actualizar
                            </button>
                        </div>
                    </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
