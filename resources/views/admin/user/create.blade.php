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
                            <i class="bi bi-person-plus-fill"></i> Crear Usuario
                        </h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.listar') }}" class="btn btn-light btn-sm fw-semibold px-3 py-2 shadow-sm">
                                <i class="bi bi-arrow-left-circle me-1"></i> Regresar
                            </a>
                            <button type="submit" form="formCrearUsuario"
                                    class="btn btn-success btn-sm fw-semibold px-3 py-2 shadow-sm">
                                <i class="bi bi-check-circle me-1"></i> Guardar
                            </button>
                        </div>
                    </div>

                    <!-- Cuerpo -->
                    <div class="card-body bg-light">
                        @include('partials.errorsuccess')

                        <form id="formCrearUsuario" action="{{ route('admin.users.guardar') }}" method="POST">
                            @csrf

                            <!-- Información básica -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-primary mb-3">Información básica</h5>

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nombre completo</label>
                                    <input type="text" id="name" name="name" class="form-control shadow-sm"
                                           placeholder="Ejemplo: Juan Pérez" value="{{ old('name') }}" required>
                                    <small class="text-muted">Usa el nombre tal como aparecerá en reportes y registros.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                    <input type="email" id="email" name="email" class="form-control shadow-sm"
                                           placeholder="usuario@empresa.com" value="{{ old('email') }}" required>
                                    <small class="text-muted">Este será el usuario para iniciar sesión.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Contraseña</label>
                                    <input type="password" id="password" name="password" class="form-control shadow-sm"
                                           placeholder="Mínimo 8 caracteres" required>
                                    <small class="text-muted">Crea una contraseña segura y fácil de recordar.</small>
                                </div>
                            </div>

                            <!-- Roles -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-primary mb-3">Roles del usuario</h5>
                                <div class="card border-0 shadow-sm p-3">
                                    <div class="row">
                                        @foreach($roles as $role)
                                            <div class="col-md-4 col-sm-6 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="roles[]" id="role_{{ $role->id }}"
                                                           value="{{ $role->name }}"
                                                           @if(isset($user) && $user->roles->contains('name', $role->name)) checked @endif>
                                                    <label class="form-check-label" for="role_{{ $role->id }}">
                                                        {{ ucfirst($role->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Permisos -->
                            <div class="mb-4">
                                <h5 class="fw-semibold text-primary mb-3">Permisos específicos</h5>

                                <div class="card border-0 shadow-sm p-3">
                                    <p class="text-muted small mb-3">
                                        Asigna permisos adicionales o deja los predeterminados del rol.
                                    </p>

                                    <div id="permisosContainer" class="row">
                                        @foreach($permissions as $index => $permission)
                                            <div class="col-md-4 col-sm-6 mb-2 permiso-item
                                            {{ $index >= 6 ? 'd-none permiso-extra' : '' }}">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                           name="permissions[]" id="permission_{{ $permission->id }}"
                                                           value="{{ $permission->name }}"
                                                           @if(isset($user) && $user->permissions->contains('name', $permission->name)) checked @endif>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ ucfirst($permission->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Botón Ver más -->
                                    @if(count($permissions) > 6)
                                        <div class="text-center mt-3">
                                            <button type="button" id="togglePermisosBtn" class="btn btn-outline-primary btn-sm px-4">
                                                <i class="bi bi-chevron-down me-1"></i> Ver más
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script dinámico para Ver más / Ver menos -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("togglePermisosBtn");
            if (!btn) return;

            btn.addEventListener("click", function () {
                const extras = document.querySelectorAll(".permiso-extra");
                const expanded = btn.getAttribute("data-expanded") === "true";

                extras.forEach(item => item.classList.toggle("d-none"));
                btn.innerHTML = expanded
                    ? '<i class="bi bi-chevron-down me-1"></i> Ver más'
                    : '<i class="bi bi-chevron-up me-1"></i> Ver menos';

                btn.setAttribute("data-expanded", !expanded);
            });
        });
    </script>
@endsection
