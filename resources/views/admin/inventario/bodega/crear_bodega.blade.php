@extends('layouts.app')

@section('content')
    <div class="container py-4 d-flex justify-content-center">

        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-white text-center border-0 pt-4 pb-0">
                    <h3 class="fw-bold mb-1" style="color:#2271B4;">Crear Bodega</h3>
                    <p class="text-muted">Registra una nueva bodega al SIGOP</p>
                </div>

                <div class="card-body px-4">

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.bodegas.crear.post') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Código</label>

                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-link-45deg text-primary"></i>
                            </span>

                                <input type="text"
                                       name="referencia"
                                       class="form-control border-start-0 @error('referencia') is-invalid @enderror"
                                       required>
                                </div>

                            @error('referencia')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Descripción</label>

                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-box text-primary"></i>
                            </span>

                                <input type="text"
                                       name="descripcion"
                                       class="form-control border-start-0 @error('descripcion') is-invalid @enderror"
                                       placeholder="Materiales de Baja rotación"
                                       required>
                                </div>

                            @error('descripcion')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit"
                                    class="btn text-white fw-semibold py-2 shadow-sm"
                                    style="background: linear-gradient(90deg, #2271B4, #4AA0E6); border-radius: 8px;">
                                <i class="bi bi-check-circle me-1"></i> Guardar Bodega
                            </button>
                        </div>

                    </form>
                </div>

                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('admin.bodegas.listar') }}"
                       class="text-decoration-none fw-semibold"
                       style="color:#4AA0E6;">
                        <i class="bi bi-arrow-left"></i> Volver a la lista
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
