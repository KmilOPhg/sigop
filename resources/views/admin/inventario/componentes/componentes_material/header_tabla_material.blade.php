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

        <a href="{{ route('admin.materiales.crear.form') }}"
           class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">add</span>
            Nuevo Material
        </a>
    </div>
</div>

@include('partials.errorsuccess')

{{-- Table --}}
<div id="contenedor_tabla_materiales">
    @include('admin.inventario.componentes.componentes_material.tabla_material')
</div>