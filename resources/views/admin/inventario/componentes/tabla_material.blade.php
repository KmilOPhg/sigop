<div class="table-responsive vh-100">
    <table class="table align-middle table-hover text-center mb-0">

        <thead style="background-color:#4AA0E6; color:#fff;">
        <tr>
            <th class="text-uppercase small fw-semibold px-3">ID</th>
            <th class="text-uppercase small fw-semibold px-3">Material</th>
            <th class="text-uppercase small fw-semibold px-3">Unidad</th>
            <th class="text-uppercase small fw-semibold px-3">Estado</th>
            {{--<th class="text-uppercase small fw-semibold px-3">Creado por</th>--}}
            <th class="text-uppercase small fw-semibold px-3">Editado por</th>
            <th class="text-uppercase small fw-semibold px-3">Acciones</th>
        </tr>
        </thead>

        <tbody>
        @forelse ($materiales as $material)
        <tr class="bg-white border-bottom {{ $material->estado === 'inactivo' ? 'opacity-50' : '' }}">

            {{-- Columna ID --}}
            <td class="fw-semibold">{{ $material->id }}</td>

            <td class="fw-semibold text-start ps-3">
                <i class="bi bi-tag-fill me-1" style="color:#2271B4;"></i>
                {{ $material->nombre_material }}
            </td>

            <td>
                <span class="badge rounded-pill text-white"
                      style="background-color:#4AA0E6;">
                    {{ $material->unidad_medida }}
                </span>
            </td>

            {{-- Estado de material --}}
            <td>
                <button
                    class="btn toggleEstadoBtn badge {{ $material->estado === 'activo' ? 'btn-success' : 'btn-danger' }} text-white fw-semibold px-3 py-2"
                    data-material-id="{{ $material->id }}"
                    data-estado="{{ $material->estado === 'activo' ? 'inactivo' : 'activo' }}">
                    {{ ucfirst($material->estado) }}
                </button>
            </td>

            <td class="text-muted">
                <i class="bi bi-person-circle me-1"></i>
                {{ $material->user?->name ?? 'N/A' }}
            </td>


            {{-- PRO Dinamico que muestra que usuario fue el ultimo en modificar
            <td class="text-muted">
                <i class="bi bi-person-check-fill me-1"></i>
                {{ $material->editor?->name ?? 'N/A' }}
            </td>--}}

            <td>
                <div class="d-flex justify-content-center flex-wrap gap-2">
                    <a href="{{ route('admin.materiales.editar', $material->id) }}"
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
                <i class="bi bi-inbox me-2"></i>No hay materiales registrados.
            </td>
        </tr>
        @endforelse
        </tbody>
    </table>

    <div class="pagination-wrapper">
        {{ $materiales->links('pagination::bootstrap-5') }}
    </div>
</div>
