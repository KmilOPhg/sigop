@extends('layouts.app')
@vite(['resources/js/app.js', 'resources/css/app.css'])

@section('content')
    <div class="space-y-6"
         x-data="{
            showCreate: false,
            showEdit: false,
            showPermisos: false,
            editUser: null,
            permisosTarget: null,
            selectedPermisos: [],

            openPermisos(target, existing = []) {
                this.permisosTarget = target;
                this.selectedPermisos = [...existing];
                this.showPermisos = true;
            },
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
            },
            grupoIndeterminado(permisos) {
                const sel = permisos.filter(p => this.selectedPermisos.includes(p.name)).length;
                return sel > 0 && sel < permisos.length;
            },
            confirmarPermisos() {
                this.showPermisos = false;
            }
         }">

        {{-- Header --}}
        <div class="flex items-end justify-between">
            <div>
                <span class="text-xs font-bold text-primary/40 uppercase tracking-[0.2em]">Administracion</span>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface mt-1">Gestion de Usuarios</h2>
            </div>
            <button @click="showCreate = true; selectedPermisos = []"
                    class="px-5 py-2.5 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Crear Usuario
            </button>
        </div>

        @include('partials.errorsuccess')

        {{-- Table --}}
        <div class="bg-surface-container-low rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                    <tr class="bg-surface-container-high/50">
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Nombre</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Roles</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Permisos</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Email</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter">Estado</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-500 tracking-tighter text-right">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200/40">
                    @forelse ($users as $user)
                        <tr class="hover:bg-surface-container-lowest transition-colors {{ $user->estado === 'inactivo' ? 'opacity-50' : '' }}">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <span class="text-xs font-semibold text-primary">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                @php $userRoles = $user->getRoleNames(); @endphp
                                @if ($userRoles->isNotEmpty())
                                    @foreach ($userRoles as $role)
                                        <span class="px-2 py-1 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded">{{ ucfirst($role) }}</span>
                                    @endforeach
                                @else
                                    <span class="text-xs text-slate-400 italic">Sin rol</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                @php $userPermissions = $user->getPermissionNames(); @endphp
                                @if ($user->hasRole('admin'))
                                    <span class="px-2 py-1 bg-tertiary-fixed text-on-tertiary-container text-[10px] font-bold rounded">Acceso total</span>
                                @elseif ($userPermissions->isNotEmpty())
                                    @foreach ($userPermissions->take(3) as $permission)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded mr-1">{{ ucfirst($permission) }}</span>
                                    @endforeach
                                    @if ($userPermissions->count() > 3)
                                        <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded cursor-pointer" title="{{ $userPermissions->slice(3)->implode(', ') }}">+{{ $userPermissions->count() - 3 }}</span>
                                    @endif
                                @else
                                    <span class="text-xs text-slate-400 italic">Sin permisos</span>
                                @endif
                            </td>
                            <td class="px-6 py-5"><span class="text-xs text-slate-500">{{ $user->email }}</span></td>
                            <td class="px-6 py-5">
                                <button class="btn-cambiar-estado px-2 py-1 text-[10px] font-bold rounded {{ $user->estado === 'activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}"
                                        data-user-id="{{ $user->id }}" data-user="{{ $user }}"
                                        data-estado="{{ $user->estado === 'activo' ? 'inactivo' : 'activo' }}">
                                    {{ ucfirst($user->estado) }}
                                </button>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <button @click="editUser = {{ $user->id }}; showEdit = true; selectedPermisos = {{ json_encode($user->getPermissionNames()) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-surface-container-high text-primary text-[10px] font-bold uppercase tracking-widest rounded hover:bg-blue-50 transition-colors">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-3xl mb-2 block">person_off</span>
                                No se encontraron usuarios.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Crear Usuario --}}
        <div x-show="showCreate" x-transition.opacity class="fixed inset-0 z-50" style="display:none">
            <div class="fixed inset-0 bg-black/50" @click="if(!showPermisos) showCreate = false"></div>
            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-8">
                    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl"
                         x-transition.scale.95>
                        <div class="bg-white border-b border-slate-200/50 px-6 py-3 flex items-center justify-between rounded-t-xl">
                            <div>
                                <h3 class="text-lg font-bold text-on-surface">Crear Usuario</h3>
                                <p class="text-[10px] text-slate-400">Registra un nuevo usuario en el sistema</p>
                            </div>
                            <button @click="showCreate = false" class="p-1 text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <form action="{{ route('admin.users.guardar') }}" method="POST" class="p-5 space-y-4">
                            @csrf
                            {{-- Info basica --}}
                            <div>
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60 mb-2">Informacion Basica</h4>
                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nombre completo</label>
                                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan Perez" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Correo electronico</label>
                                        <input type="email" name="email" value="{{ old('email') }}" placeholder="usuario@empresa.com" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Contrasena</label>
                                        <input type="password" name="password" placeholder="Minimo 8 caracteres" required
                                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            {{-- Roles --}}
                            <div>
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60 mb-2">Rol del Usuario</h4>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($roles as $role)
                                        <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors text-xs">
                                            <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20">
                                            {{ ucfirst($role->name) }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Permisos: boton para abrir popup --}}
                            <div>
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60 mb-2">Permisos</h4>
                                <div class="flex items-center gap-3">
                                    <button type="button" @click="openPermisos('create', selectedPermisos)"
                                            class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-primary hover:bg-blue-50 transition-colors flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">tune</span>
                                        Configurar Permisos
                                    </button>
                                    <span class="text-[10px] text-slate-400" x-show="selectedPermisos.length > 0"
                                          x-text="selectedPermisos.length + ' permiso(s) seleccionado(s)'"></span>
                                    <span class="text-[10px] text-slate-400 italic" x-show="selectedPermisos.length === 0">Sin permisos adicionales</span>
                                </div>
                                {{-- Hidden inputs para enviar permisos seleccionados --}}
                                <template x-for="perm in selectedPermisos" :key="perm">
                                    <input type="hidden" name="permissions[]" :value="perm">
                                </template>
                            </div>

                            <div class="flex justify-end gap-3 pt-3 border-t border-slate-200/50">
                                <button type="button" @click="showCreate = false"
                                        class="px-5 py-2 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit"
                                        class="px-5 py-2 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modales Editar Usuario --}}
        @foreach($users as $user)
            <div x-show="showEdit && editUser === {{ $user->id }}" x-transition.opacity class="fixed inset-0 z-50" style="display:none">
                <div class="fixed inset-0 bg-black/50" @click="if(!showPermisos) showEdit = false"></div>
                <div class="fixed inset-0 overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-8">
                        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-2xl" x-transition.scale.95>
                            <div class="bg-white border-b border-slate-200/50 px-6 py-4 flex items-center justify-between rounded-t-xl">
                                <div>
                                    <h3 class="text-lg font-bold text-on-surface">Editar Usuario</h3>
                                    <p class="text-[10px] text-slate-400">{{ $user->name }} &mdash; {{ $user->email }}</p>
                                </div>
                                <button @click="showEdit = false" class="p-1 text-slate-400 hover:text-slate-600 transition-colors">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                            <form action="{{ route('admin.users.actualizar', $user) }}" method="POST" class="p-6 space-y-5">
                                @csrf
                                @method('PUT')

                                <div class="space-y-4">
                                    <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60">Informacion Basica</h4>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Nombre</label>
                                            <input type="text" name="name" value="{{ $user->name }}" required
                                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                                            <input type="email" name="email" value="{{ $user->email }}" required
                                                   class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Estado</label>
                                        <select name="estado"
                                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                                            <option value="activo" {{ $user->estado === 'activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="inactivo" {{ $user->estado === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Roles --}}
                                <div>
                                    <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60 mb-2">Rol del Usuario</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        @foreach($roles as $role)
                                            <label class="flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg cursor-pointer hover:bg-blue-50 transition-colors text-xs">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500/20"
                                                       {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Permisos: boton para abrir popup --}}
                                <div>
                                    <h4 class="text-[10px] font-bold uppercase tracking-wider text-primary/60 mb-2">Permisos</h4>
                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="openPermisos('edit-{{ $user->id }}', selectedPermisos)"
                                                class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-primary hover:bg-blue-50 transition-colors flex items-center gap-2">
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

                                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200/50">
                                    <button type="button" @click="showEdit = false"
                                            class="px-5 py-2 bg-surface-container-high text-primary rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-colors">
                                        Cancelar
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 bg-gradient-to-r from-primary to-primary-container text-white rounded-lg text-xs font-bold uppercase tracking-widest shadow-lg shadow-blue-900/20 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Actualizar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Popup de Permisos Agrupados --}}
        @include('admin.user._popup_permisos')
    </div>
@endsection
