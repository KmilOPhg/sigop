<div class="card border-0 shadow-lg rounded-4 overflow-hidden">
    <div class="card-header d-flex justify-content-between align-items-center py-3 text-white"
         style="background-color:#2271B4;">
        <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
            <i class="bi bi-box-seam"></i> Gestión de Bodegas
        </h4>

        @if($modo === 'activo')
            <a href="{{ route('admin.bodegas.listar', 'inactivo') }}"
               class="ajax-load btn btn-light btn-sm fw-semibold px-3 py-2 shadow-sm">
                <i class="bi bi-eye-slash me-1"></i> Ver Inactivos
            </a>
        @else
            <a href="{{ route('admin.bodegas.listar', 'activo') }}"
               class="ajax-load btn btn-light btn-sm fw-semibold px-3 py-2 shadow-sm">
                <i class="bi bi-eye me-1"></i> Ver Activos
            </a>
        @endif

        <a href="{{ route('admin.bodegas.crear.form') }}"
           class="btn btn-light btn-sm fw-semibold px-3 py-2 shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Nueva Bodega
        </a>
    </div>

    <div class="card-body bg-light">
        @include('partials.errorsuccess')

        <div id="contenedor_tabla_bodega">
            @include('admin.inventario.componentes.componentes_bodegas.tabla_bodega')
        </div>
    </div>
</div>
