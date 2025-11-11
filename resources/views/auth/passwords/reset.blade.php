<!doctype html>
@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center flex-grow-1">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <!-- Encabezado -->
                <div class="card-header text-center bg-white border-0 pb-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 24 24"><path fill="#2777ba" d="M18 16.663a3.5 3.5 0 0 1-2-3.163a3.5 3.5 0 1 1 4.5 3.355V17l1.146 1.146a.5.5 0 0 1 0 .708L20.5 20l1.161 1.161a.5.5 0 0 1 .015.692l-1.823 1.984a.5.5 0 0 1-.722.015l-.985-.984a.5.5 0 0 1-.146-.354zM20.5 13a1 1 0 1 0-2 0a1 1 0 0 0 2 0M17 17.242v3.69c-1.36.714-3.031 1.07-5 1.07c-3.42 0-5.944-1.073-7.486-3.237a2.75 2.75 0 0 1-.51-1.596v-.92a2.25 2.25 0 0 1 2.249-2.25h8.775A4.5 4.5 0 0 0 17 17.243M12 2.005a5 5 0 1 1 0 10a5 5 0 0 1 0-10"/></svg>
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
