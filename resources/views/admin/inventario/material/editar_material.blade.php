@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto space-y-6">
        <div>
            <a href="{{ route('admin.materiales.listar') }}" class="inline-flex items-center gap-1 text-xs text-secondary hover:text-primary transition-colors mb-4">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Volver a la lista
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-on-surface">Editar Material</h2>
            <p class="text-xs text-slate-500 mt-1">Modifica la información del material</p>
        </div>

        @if($errors->any())
            <div class="px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-xs font-medium flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">error</span>
                {{ $errors->first() }}
            </div>
        @endif

        <div class="bg-surface-container-low rounded-xl p-6">
            <form action="{{ route('admin.materiales.actualizar', $material) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nombre del material</label>
                    <input type="text" name="nombre_material" value="{{ old('nombre_material', $material->nombre_material) }}" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all @error('nombre_material') border-red-400 @enderror">
                    @error('nombre_material')
                        <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Unidad de medida</label>
                    <select name="unidad_medida" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all @error('unidad_medida') border-red-400 @enderror">
                        <option value="" disabled>Selecciona una unidad</option>
                        @foreach(['UND','KLS','MTS','LAM','PAR','DCM','LTS','CM','RLL','GLS','LAT','LBS','BTS','MILFS','GRS','DOC','GRAM','GARR'] as $u)
                            <option value="{{ $u }}" {{ old('unidad_medida', $material->unidad_medida) == $u ? 'selected' : '' }}>{{ $u }}</option>
                        @endforeach
                    </select>
                    @error('unidad_medida')
                        <p class="text-[10px] text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Actualizar Material
                </button>
            </form>
        </div>
    </div>
@endsection
