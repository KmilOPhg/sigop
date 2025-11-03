@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <b>Users</b>
                        <a href="{{ route('admin.users.listar') }}">New User</a>
                    </div>
                    <div class="card-body">
                        @include('partials.errorsuccess')
                        <table class="table table-bordered table-hover align-middle text-center shadow-sm w-100" style="table-layout: fixed;">
                            <thead class="table-primary">
                            <tr>
                                <th style="width: 20%;">Nombre</th>
                                <th style="width: 20%;">Roles</th>
                                <th style="width: 20%;">Permisos</th>
                                <th style="width: 25%;">Email</th>
                                <th style="width: 20%;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="text-truncate" title="{{ $user->name }}">{{ $user->name }}</td>

                                    <!-- Roles -->
                                    <td class="text-start">
                                        @php
                                            $roles = $user->getRoleNames();
                                        @endphp
                                        @if ($roles->isNotEmpty())
                                            @foreach ($roles as $role)
                                                <span class="badge bg-secondary mb-1">{{ $role }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin rol</span>
                                        @endif
                                    </td>

                                    <!-- Permisos -->
                                    <td class="text-start">
                                        @php
                                            $permissions = $user->getPermissionNames();
                                        @endphp
                                        @if ($user->hasRole('admin'))
                                            <span class="badge bg-info text-dark mb-1">Acceso total</span>
                                        @elseif ($permissions->isNotEmpty())
                                            @foreach ($permissions as $permission)
                                                <span class="badge bg-info text-dark mb-1">{{ $permission }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin permisos</span>
                                        @endif
                                    </td>

                                    <!-- Email -->
                                    <td class="text-truncate" title="{{ $user->email }}">{{ $user->email }}</td>

                                    <!-- Acciones -->
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('admin.users.editar.form', $user->id) }}" class="btn btn-sm btn-warning d-flex align-items-center gap-1">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>

                                            <form action="{{ route('admin.users.eliminar', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger d-flex align-items-center gap-1">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted">No se encontraron usuarios.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
