@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('admin.users.update', $user) }}" method="post">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <b>Actualzar usuario</b>
                            <a href="{{ route('admin.users.index') }}">Regresar</a>
                            <button type="submit">Actualizar</button>
                        </div>
                        <div class="card-body">
                            @include('partials.errorsuccess')

                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name',$user->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email',$user->email) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="roles" class="form-label">Roles</label>
                                <div id="roles" class="d-flex flex-wrap gap-2">
                                    @foreach($roles as $role)
                                        <label class="me-3">
                                            <input
                                                type="checkbox"
                                                name="roles[]"
                                                value="{{ $role->name }}"
                                                {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                            >
                                            {{ $role->name }}
                                        </label>
                                    @endforeach
                                </div>

                                <hr>

                                <label for="permissions" class="form-label">Permisos</label>
                                <div id="permissions" class="d-flex flex-wrap gap-2">
                                    @foreach($permissions as $permission)
                                        <label class="me-3">
                                            <input
                                                type="checkbox"
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                            >
                                            {{ $permission->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
