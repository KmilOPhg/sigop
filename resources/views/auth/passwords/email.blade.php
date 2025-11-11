@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Encabezado -->
                <div class="card-header text-center bg-white border-0 pb-0">
                    <span class="icon-[fluent--person-passkey-32-filled]"></span>
                    <h3 class="fw-bold mb-1" style="color:#2271B4;">Recuperar Contraseña</h3>
                    <p class="text-muted mb-3">Ingresa tu correo y selecciona un receptor para recibir el enlace</p>
                </div>

                <!-- Cuerpo -->
                <div class="card-body px-4 py-4">

                    @if (session('status'))
                        <div class="alert alert-success text-center fw-semibold shadow-sm rounded-3">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        {{-- Correo del usuario --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-secondary">Correo registrado</label>
                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope text-primary"></i>
                            </span>
                                <input id="email"
                                       type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       placeholder="tu-correo@empresa.com"
                                       autofocus>
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        {{-- Receptor de recuperación --}}
                        <div class="mb-4">
                            <label for="cmb-admin" class="form-label fw-semibold text-secondary">Receptor de recuperación</label>
                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-person-check text-primary"></i>
                            </span>
                                <select class="form-select border-start-0" id="cmb-admin" name="email_admin" required>
                                    <option selected disabled>Selecciona un correo de receptor</option>
                                    @foreach($user as $users)
                                        <option value="{{ $users->email }}">{{ $users->email }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Botón de envío --}}
                        <div class="d-grid">
                            <button type="submit"
                                    class="btn text-white fw-semibold py-2 shadow-sm"
                                    style="background: linear-gradient(90deg, #2271B4, #4AA0E6); border-radius: 8px;">
                                <i class="bi bi-envelope-check me-2"></i> Enviar enlace de recuperación
                            </button>
                        </div>

                    </form>
                </div>

                <!-- Pie -->
                <div class="card-footer bg-white border-0 text-center py-3">
                    <small class="text-muted">
                        ¿Recordaste tu contraseña?
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color:#4AA0E6;">Iniciar sesión</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
