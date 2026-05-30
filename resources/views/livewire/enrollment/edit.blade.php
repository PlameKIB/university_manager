<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
                </div>
                Modifier l'inscription
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Modification de l'inscription académique d'un étudiant
            </p>
        </div>
    </div>

    {{-- CARTE ÉTUDIANT (lecture seule) --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-5">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center flex-shrink-0">
                <span class="text-indigo-600 dark:text-indigo-400 font-bold text-lg">
                    {{ strtoupper(substr($enrollment->student->nom, 0, 1)) }}{{ strtoupper(substr($enrollment->student->prenom ?? '', 0, 1)) }}
                </span>
            </div>
            <div class="flex-1">
                <p class="font-bold text-gray-800 dark:text-white">
                    {{ $enrollment->student->nom }} {{ $enrollment->student->postnom }} {{ $enrollment->student->prenom }}
                </p>
                <div class="flex items-center gap-4 mt-1 text-sm text-gray-500 dark:text-gray-400">
                    <span><i class="fa-solid fa-id-card mr-1.5"></i>{{ $enrollment->student->matricule }}</span>
                    @if($enrollment->student->telephone)
                        <span><i class="fa-solid fa-phone mr-1.5"></i>{{ $enrollment->student->telephone }}</span>
                    @endif
                </div>
            </div>
            <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-semibold rounded-full">
                Étudiant existant
            </span>
        </div>
    </div>

    {{-- FORMULAIRE ACADÉMIQUE --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                <i class="fa-solid fa-school text-indigo-500 text-sm"></i>
            </div>
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">Informations académiques</h3>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            {{-- Année académique --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Année académique</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-calendar-days text-gray-400 text-sm"></i>
                    </div>
                    <select wire:model.live="academic_year_id"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                        <option value="">Sélectionner…</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Faculté --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Faculté</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-building-columns text-gray-400 text-sm"></i>
                    </div>
                    <select wire:model.live="faculty_id"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                        <option value="">Sélectionner…</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Département --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Département</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-sitemap text-gray-400 text-sm"></i>
                    </div>
                    <select wire:model.live="department_id"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-sm transition appearance-none
                               {{ count($departments) === 0
                                   ? 'text-gray-400 cursor-not-allowed'
                                   : 'text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent' }}"
                        {{ count($departments) === 0 ? 'disabled' : '' }}>
                        <option value="">{{ count($departments) === 0 ? 'Choisir une faculté d\'abord' : 'Sélectionner…' }}</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept['id'] }}">{{ $dept['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Promotion --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Promotion</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-layer-group text-gray-400 text-sm"></i>
                    </div>
                    <select wire:model.live="promotion_id"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-sm transition appearance-none
                               {{ count($promotions) === 0
                                   ? 'text-gray-400 cursor-not-allowed'
                                   : 'text-gray-800 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent' }}"
                        {{ count($promotions) === 0 ? 'disabled' : '' }}>
                        <option value="">{{ count($promotions) === 0 ? 'Choisir un département d\'abord' : 'Sélectionner…' }}</option>
                        @foreach($promotions as $promo)
                            <option value="{{ $promo['id'] }}">{{ $promo['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Date d'inscription --}}
            <div class="space-y-1.5">
                <label class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Date d'inscription</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-calendar-check text-gray-400 text-sm"></i>
                    </div>
                    <input type="date" wire:model="registration_date"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>
            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="px-6 pb-6 flex items-center justify-between">
            <a href="{{ route('enrollment.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-700
                       text-gray-700 dark:text-white rounded-xl font-semibold text-sm
                       hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                <i class="fa-solid fa-xmark text-xs"></i>
                Annuler
            </a>
            <button wire:click="save"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700
                       disabled:opacity-60 text-white rounded-xl font-semibold text-sm transition shadow-sm">
                <span wire:loading.remove wire:target="save">
                    <i class="fa-solid fa-floppy-disk"></i>
                </span>
                <span wire:loading wire:target="save">
                    <i class="fa-solid fa-circle-notch fa-spin"></i>
                </span>
                Enregistrer les modifications
            </button>
        </div>
    </div>

</div>

@script
<script>
    $wire.on('success', (event) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: event.message,
            showConfirmButton: false,
            timer: 3000,
            background: '#1f2937',
            color: '#fff'
        });
    });
</script>
@endscript