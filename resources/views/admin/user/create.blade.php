@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6"
         x-data="{
            showPermisos: false,
            selectedPermisos: [],
            togglePermiso(name) {
                const idx = this.selectedPermisos.indexOf(name);
                if (idx > -1) this.selectedPermisos.splice(idx, 1);
                else this.selectedPermisos.push(name);
            },
            toggleGrupo(permisos) {
                const names = permisos.map(p => p.name);
                const allSelected = names.every(n => this.selectedPermisos.includes(n));
                if (allSelected) {
                    this.selectedPermisos = this.selectedPermisos.filter(n => !names.includes(n));
                } else {
                    names.forEach(n => { if (!this.selectedPermisos.includes(n)) this.selectedPermisos.push(n); });
                }
            },
            grupoSeleccionado(permisos) {
                return permisos.every(p => this.selectedPermisos.includes(p.name));
            }
         }">

        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.users.listar') }}" class="inline-flex items-center gap-1 text-xs text-secondary hover:text-primary transition-colors mb-4">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Volver a la lista
                </a>
                <h2 class="text-2xl font-bold tracking-tight text-on-surface">Crear Usuario</h2>
            </div>
            <button type="submit" form="formCrearUsuario"
                    class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">check_circle</span>
                Guardar
            </button>
        </div>

        @include('partials.errorsuccess')

        <form id="formCrearUsuario" action="{{ route('admin.users.guardar') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Informacion basica --}}
            <div class="bg-surface-container-low rounded-xl p-6 space-y-5">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Informacion Basica</h3>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ejemplo: Juan Perez" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    <p class="text-[10px] text-slate-400 mt-1">Nombre tal como aparecera en reportes y registros.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Correo electronico</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="usuario@empresa.com" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                    <p class="text-[10px] text-slate-400 mt-1">Usuario para iniciar sesion.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Contrasena</label>
                    <input type="password" name="password" placeholder="Minimo 8 caracteres" required
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>
            </div>

            {{-- Roles --}}
            <div class="bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-4">Rol del Usuario</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($roles as $role)
                        <label class="flex items-center gap-2 px-3 py-2.5 bg-white border border-slate-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors text-xs">
                            <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                   class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20">
                            {{ ucfirst($role->name) }}
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- Permisos --}}
            <div class="bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold uppercase tracking-wider text-primary/60 mb-2">Permisos Especificos</h3>
                <p class="text-[10px] text-slate-400 mb-4">Asigna permisos adicionales o deja los predeterminados del rol.</p>

                <div class="flex items-center gap-3">
                    <button type="button" @click="showPermisos = true"
                            class="px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-primary hover:bg-blue-50 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">tune</span>
                        Configurar Permisos
                    </button>
                    <span class="text-[10px] text-slate-400" x-show="selectedPermisos.length > 0"
                          x-text="selectedPermisos.length + ' permiso(s) seleccionado(s)'"></span>
                    <span class="text-[10px] text-slate-400 italic" x-show="selectedPermisos.length === 0">Sin permisos adicionales</span>
                </div>

                <template x-for="perm in selectedPermisos" :key="perm">
                    <input type="hidden" name="permissions[]" :value="perm">
                </template>
            </div>
        </form>

        {{-- Popup de Permisos --}}
        @include('admin.user._popup_permisos')
    </div>
@endsection
