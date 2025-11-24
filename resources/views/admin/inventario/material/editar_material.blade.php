@extends('layouts.app')

@section('content')
    <div class="container py-4 d-flex justify-content-center">

        <div class="col-md-7 col-lg-6">
            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-white text-center border-0 pt-4 pb-0">
                    <h3 class="fw-bold mb-1" style="color:#2271B4;">Crear Material</h3>
                    <p class="text-muted">Registra un nuevo material en el sistema</p>
                </div>

                <div class="card-body px-4">

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.materiales.actualizar', $material) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Nombre del material</label>

                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-box text-primary"></i>
                            </span>
                                <input type="text"
                                       id="name"
                                       name="nombre_material"
                                       value="{{ old('name',$material->nombre_material) }}"
                                       class="form-control border-start-0 @error('nombre_material') is-invalid @enderror"
                                       required>
                            </div>

                            @error('nombre_material')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Unidad de medida</label>

                            <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-rulers text-primary"></i>
                            </span>

                                <select name="unidad_medida"
                                        class="form-select border-start-0 @error('unidad_medida') is-invalid @enderror"
                                        required>

                                    <option value="" disabled>Selecciona una unidad</option>

                                    @php
                                        $unidades = ['UND','KLS','MTS','LAM','PAR','DCM','LTS','CM','RLL','GLS','LAT','LBS','BTS','MILFS','GRS','DOC','GRAM','GARR'];
                                    @endphp

                                    @foreach ($unidades as $unidad)
                                        <option value="{{ $unidad }}"
                                            {{ old('unidad_medida', $material->unidad_medida) == $unidad ? 'selected' : '' }}>
                                            {{ $unidad }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @error('unidad_medida')
                            <span class="invalid-feedback d-block mt-1">
                                <i class="bi bi-exclamation-circle"></i> {{ $message }}
                            </span>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit"
                                    class="btn text-white fw-semibold py-2 shadow-sm"
                                    style="background: linear-gradient(90deg, #2271B4, #4AA0E6); border-radius: 8px;">
                                <i class="bi bi-check-circle me-1"></i> Guardar Material
                            </button>
                        </div>

                    </form>
                </div>

                <div class="card-footer bg-white border-0 text-center py-3">
                    <a href="{{ route('admin.materiales.listar') }}"
                       class="text-decoration-none fw-semibold"
                       style="color:#4AA0E6;">
                        <i class="bi bi-arrow-left"></i> Volver a la lista
                    </a>
                </div>

            </div>
        </div>

    </div>
@endsection
