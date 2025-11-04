@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Tarjeta principal -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    <!-- Encabezado -->
                    <div class="card-header d-flex justify-content-between align-items-center py-3 text-white"
                         style="background-color:#2271B4;">
                        <h4 class="mb-0 fw-bold d-flex align-items-center gap-2">
                            <i class="bi bi-people-fill"></i> Gestión de Usuarios
                        </h4>
                        <a href="{{ route('admin.users.crear.form') }}"
                           class="btn btn-light btn-sm fw-semibold px-3 py-2 shadow-sm">
                            <i class="bi bi-person-plus-fill me-1"></i> Crear Usuario
                        </a>
                    </div>

                    <!-- Cuerpo -->
                    <div class="card-body bg-light">
                        @include('partials.errorsuccess')

                        <div class="table-responsive vh-100">
                            <table class="table align-middle table-hover text-center mb-0">
                                <thead style="background-color:#4AA0E6; color:#fff;">
                                <tr>
                                    <th class="text-uppercase small fw-semibold px-3">Nombre</th>
                                    <th class="text-uppercase small fw-semibold px-3">Roles</th>
                                    <th class="text-uppercase small fw-semibold px-3">Permisos</th>
                                    <th class="text-uppercase small fw-semibold px-3">Email</th>
                                    <th class="text-uppercase small fw-semibold px-3">Estado</th>
                                    <th class="text-uppercase small fw-semibold px-3">Acciones</th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($users as $user)
                                    <tr class="bg-white border-bottom {{ $user->estado === 'inactivo' ? 'opacity-50' : '' }}">
                                        <!-- Nombre -->
                                        <td class="fw-semibold text-start ps-3" title="{{ $user->name }}">
                                            <i class="bi bi-person-circle me-1" style="color:#2271B4;"></i>
                                            {{ $user->name }}
                                        </td>

                                        <!-- Roles -->
                                        <td class="text-start">
                                            @php $roles = $user->getRoleNames(); @endphp
                                            @if ($roles->isNotEmpty())
                                                @foreach ($roles as $role)
                                                    <span class="badge rounded-pill text-white mb-1"
                                                          style="background-color:#4AA0E6;">
                                                    {{ ucfirst($role) }}
                                                </span>
                                                @endforeach
                                            @else
                                                <span class="text-muted fst-italic">Sin rol</span>
                                            @endif
                                        </td>

                                        <!-- Permisos -->
                                        <td class="text-start">
                                            @php $permissions = $user->getPermissionNames(); @endphp

                                            @if ($user->hasRole('admin'))
                                                <span class="badge rounded-pill text-dark mb-1"
                                                      style="background-color:#F7A61D;">
                                                Acceso total
                                            </span>
                                            @elseif ($permissions->isNotEmpty())
                                                @php
                                                    $shownPermissions = $permissions->take(3);
                                                    $hiddenPermissions = $permissions->slice(3);
                                                @endphp

                                                @foreach ($shownPermissions as $permission)
                                                    <span class="badge rounded-pill text-white mb-1"
                                                          style="background-color:#1E9D52;">
                                                    {{ ucfirst($permission) }}
                                                </span>
                                                @endforeach

                                                @if ($hiddenPermissions->isNotEmpty())
                                                    <div class="dropdown d-inline-block">
                                                        <button class="btn btn-sm btn-outline-secondary rounded-circle px-2 py-0 dropdown-toggle"
                                                                type="button"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false"
                                                                title="Ver más permisos">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>
                                                        <ul class="dropdown-menu p-2 shadow-sm">
                                                            @foreach ($hiddenPermissions as $perm)
                                                                <li>
                                                                    <span class="badge bg-success d-block mb-1">{{ ucfirst($perm) }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            @else
                                                <span class="text-muted fst-italic">Sin permisos</span>
                                            @endif
                                        </td>

                                        <!-- Email -->
                                        <td class="text-start ps-3 text-muted" title="{{ $user->email }}">
                                            <i class="bi bi-envelope-at me-1"></i>{{ $user->email }}
                                        </td>

                                        <!-- Estado -->
                                        <td>
                                            @if($user->estado === 'activo')
                                                <span class="badge bg-success text-white px-3 py-2 fw-semibold">Activo</span>
                                            @else
                                                <span class="badge bg-secondary text-white px-3 py-2 fw-semibold">Inactivo</span>
                                            @endif
                                        </td>

                                        <!-- Acciones -->
                                        <td>
                                            <div class="d-flex justify-content-center flex-wrap gap-2">
                                                <!-- Editar -->
                                                <a href="{{ route('admin.users.editar.form', $user->id) }}"
                                                   class="btn btn-sm text-white fw-semibold d-flex align-items-center gap-1"
                                                   style="background-color:#F7A61D;">
                                                    <i class="bi bi-pencil-square"></i> Editar
                                                </a>

                                                <!-- Eliminar -->
                                                @if($user->estado === 'activo')
                                                    <form action="{{ route('admin.users.eliminar', $user->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm text-white fw-semibold d-flex align-items-center gap-1"
                                                                style="background-color:#dc3545;">
                                                            <i class="bi bi-trash3"></i> Inhabilitar
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-muted py-4">
                                            <i class="bi bi-exclamation-circle me-2"></i>No se encontraron usuarios.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- Fin tarjeta -->
            </div>
        </div>
    </div>
@endsection
