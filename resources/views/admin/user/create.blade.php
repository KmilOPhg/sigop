@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('admin.users.guardar') }}" method="post">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>Crear usuario</b>
                            <a href="{{ route('admin.users.listar') }}">Regresar</a>
                            <button type="submit">Guardar</button>
                        </div>
                        <div class="card-body">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            {{-- Roles --}}
                            <div class="mb-3">
                                <label for="roles" class="form-label">Roles</label><br>
                                @foreach($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="roles[]"
                                            id="role_{{ $role->id }}"
                                            value="{{ $role->name }}"
                                            @if(isset($user) && $user->roles->contains('name', $role->name)) checked @endif
                                        >
                                        <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Permisos --}}
                            <div class="mb-3">
                                <label for="permissions" class="form-label">Permisos</label><br>
                                @foreach($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="permissions[]"
                                            id="permission_{{ $permission->id }}"
                                            value="{{ $permission->name }}"
                                            @if(isset($user) && $user->permissions->contains('name', $permission->name)) checked @endif
                                        >
                                        <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
