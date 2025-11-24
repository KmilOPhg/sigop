<div class="table-responsive vh-100">
    <table class="table align-middle table-hover text-center mb-0">

        <thead style="background-color:#4AA0E6; color:#fff;">
        <tr>
            <th class="text-uppercase small fw-semibold px-3">ID</th>
            <th class="text-uppercase small fw-semibold px-3">Codigo</th>
            <th class="text-uppercase small fw-semibold px-3">Descripcion</th>
            <th class="text-uppercase small fw-semibold px-3">Estado</th>
            <th class="text-uppercase small fw-semibold px-3">Acciones</th>
        </tr>
        </thead>

        <tbody>
        @forelse ($bodegas as $bodega)
        <tr class="bg-white border-bottom {{ $bodega->estado === 'inactivo' ? 'opacity-50' : '' }}">

            {{-- Columna ID --}}
            <td class="fw-semibold">{{ $bodega->id }}</td>

            <td class="fw-semibold text-start ps-3">
                <i class="bi bi-tag-fill me-1" style="color:#2271B4;"></i>
                {{ $bodega->referencia }}
            </td>

            {{-- Columna descripción --}}
            <td class="fw-semibold text-center ps-3">
                {{ $bodega->descripcion }}
            </td>

            {{-- Estado de la bodega --}}
            <td>
                <button
                    class="btn toggleEstadoBtn badge {{ $bodega->estado === 'activo' ? 'btn-success' : 'btn-danger' }} text-white fw-semibold px-3 py-2"
                    data-id="{{ $bodega->id }}"
                    data-seccion="bodegas"
                    data-estado="{{ $bodega->estado === 'activo' ? 'inactivo' : 'activo' }}">
                    {{ ucfirst($bodega->estado) }}
                </button>
            </td>

            <td>
                <div class="d-flex justify-content-center flex-wrap gap-2">
                    <a href="{{ route('admin.bodegas.editar', $bodega->id) }}"
                       class="btn btn-sm text-white fw-semibold d-flex align-items-center gap-1"
                       style="background-color:#F7A61D;">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-muted py-4">
                <i class="bi bi-inbox me-2"></i>No hay bodegas registradas.
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination-wrapper">
        {{ $bodegas->links('pagination::bootstrap-5') }}
    </div>
</div>
