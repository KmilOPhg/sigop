<!doctype html>
@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Encabezado -->
                <div class="card-header text-center bg-white border-0 pb-0">
                    <h3 class="fw-bold mb-1" style="color:#2271B4;">Restablecer Contraseña</h3>
                    <p class="text-muted mb-3">Crea una nueva contraseña segura para tu cuenta</p>
                </div>

                <!-- Cuerpo -->
                <div class="card-body px-4 py-4">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Correo --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold text-secondary">Correo electrónico</label>
                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-envelope text-primary"></i>
                            </span>
                                <input id="email"
                                       type="email"
                                       class="form-control border-start-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
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

                        {{-- Nueva contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold text-secondary">Nueva contraseña</label>
                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-lock text-primary"></i>
                            </span>
                                <input id="password"
                                       type="password"
                                       class="form-control border-start-0 @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Ingresa una nueva contraseña">
                            </div>
                            @error('password')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        {{-- Confirmar contraseña --}}
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label fw-semibold text-secondary">Confirmar contraseña</label>
                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-shield-lock text-primary"></i>
                            </span>
                                <input id="password-confirm"
                                       type="password"
                                       class="form-control border-start-0"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password"
                                       placeholder="Repite tu contraseña">
                            </div>
                        </div>

                        {{-- Botón de envío --}}
                        <div class="d-grid">
                            <button type="submit"
                                    class="btn text-white fw-semibold py-2 shadow-sm"
                                    style="background: linear-gradient(90deg, #2271B4, #4AA0E6); border-radius: 8px;">
                                <i class="bi bi-arrow-repeat me-2"></i> Restablecer contraseña
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Pie -->
                <div class="card-footer bg-white border-0 text-center py-3">
                    <small class="text-muted">
                        ¿Ya recordaste tu contraseña?
                        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color:#4AA0E6;">Iniciar sesión</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
