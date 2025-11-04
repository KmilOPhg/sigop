@extends('layouts.app')

@section('content')
    <div class="container-fluid d-flex justify-content-center align-items-center bg-light vh-40">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Encabezado -->
                <div class="card-header text-center bg-white border-0 pb-0">
                    <h3 class="fw-bold mb-1" style="color:#2271B4;">Bienvenido</h3>
                    <p class="text-muted mb-3">Inicia sesión para continuar</p>
                </div>

                <!-- Cuerpo -->
                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Correo --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-secondary">Correo electrónico</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>
                                <input id="email" type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="ejemplo@correo.com" autofocus>
                            </div>
                            @error('email')
                            <span class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary">Contraseña</label>
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-lock text-primary"></i>
                                </span>
                                <input id="password" type="password"
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       name="password" required placeholder="Ingresa tu contraseña">
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block mt-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        {{-- Recordar sesión y olvidé contraseña --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Recordarme</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-decoration-none small fw-semibold" href="{{ route('password.request') }}"
                                   style="color:#4AA0E6;">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        {{-- Botón de login --}}
                        <div class="d-grid">
                            <button type="submit"
                                    class="btn text-white fw-semibold py-2 shadow-sm"
                                    style="background: linear-gradient(90deg, #2271B4, #4AA0E6); border-radius: 8px; transition: all 0.3s;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Pie -->
                <div class="card-footer bg-white border-0 text-center py-3">
                    <small class="text-muted">© {{ date('Y') }} <span class="fw-semibold">SIGOP</span>. Todos los derechos reservados.</small>
                </div>
            </div>
        </div>
    </div>
@endsection
