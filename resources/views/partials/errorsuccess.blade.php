@if(session('success'))
    <div class="mb-4 flex items-start gap-3 rounded-xl border border-slate-200/70 bg-white px-4 py-3 text-xs font-medium text-on-surface shadow-sm">
        <span class="material-symbols-outlined shrink-0 text-xl text-secondary" aria-hidden="true">check_circle</span>
        <p class="min-w-0 flex-1 leading-relaxed pt-0.5">{{ session('success') }}</p>
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-xl border border-red-200/80 bg-red-50/70 px-4 py-3 text-xs text-on-surface shadow-sm">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined shrink-0 text-xl text-error" aria-hidden="true">error</span>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-on-surface mb-2">Se encontraron errores</p>
                <ul class="list-disc space-y-1 pl-4 text-on-surface-variant leading-relaxed">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
