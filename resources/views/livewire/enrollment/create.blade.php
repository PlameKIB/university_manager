<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-user-graduate text-indigo-600"></i>
                </div>
                Nouvelle inscription
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Création complète d'un étudiant et son inscription académique
            </p>
        </div>
    </div>

    {{-- STEPS --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between">
            @foreach([
                ['num' => 1, 'label' => 'Étudiant',   'sub' => 'Recherche ou création'],
                ['num' => 2, 'label' => 'Académique',  'sub' => 'Choix de filière'],
                ['num' => 3, 'label' => 'Validation',  'sub' => 'Confirmation'],
            ] as $s)
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm
                        {{ $step >= $s['num']
                            ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 dark:shadow-indigo-900'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-400' }}">
                        @if($step > $s['num'])
                            <i class="fa-solid fa-check text-xs"></i>
                        @else
                            {{ $s['num'] }}
                        @endif
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-gray-800 dark:text-white">{{ $s['label'] }}</div>
                        <div class="text-xs text-gray-400">{{ $s['sub'] }}</div>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="flex-1 mx-4">
                        <div class="h-0.5 rounded-full {{ $step > $s['num'] ? 'bg-indigo-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- ======================== STEP 1 ======================== --}}
    @if($step == 1)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-magnifying-glass text-indigo-500 text-sm"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Recherche d'étudiant</h3>
            </div>

            <div class="p-6 space-y-5">

                {{-- BARRE DE RECHERCHE --}}
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                        </div>
                     <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher par matricule, nom ou téléphone..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 transition">

                    </div>
                    <button
                        wire:click="setIsNewStudent"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                               disabled:opacity-60 text-white rounded-xl font-semibold text-sm transition shadow-sm">
                        <span wire:loading.remove wire:target="setIsNewStudent">
                            <!-- <i class="fa-solid fa-magnifying-glass"></i> -->
                             <i class="fa-solid fa-user-plus"></i>
                        </span>
                        <span wire:loading wire:target="setIsNewStudent">
                            <i class="fa-solid fa-circle-notch fa-spin"></i>
                        </span>
                        Nouvel étudiant
                    </button>
                </div>

                {{-- LISTE DES RÉSULTATS --}}
                @if(count($searchResults) > 0)
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gray-50 dark:bg-gray-900/60 px-4 py-2.5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                {{ count($searchResults) }} résultat(s) trouvé(s)
                            </span>
                            <span class="text-xs text-indigo-500 font-medium">Cliquez pour sélectionner</span>
                        </div>
                        <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($searchResults as $result)
                                <li>
                                    <button
                                        wire:click="selectStudent({{ $result['id'] }})"
                                        class="w-full text-left px-5 py-4 flex items-center gap-4
                                               hover:bg-indigo-50 dark:hover:bg-indigo-900/20
                                               focus:outline-none focus:bg-indigo-50 dark:focus:bg-indigo-900/20
                                               group transition-colors"
                                    >
                                        {{-- Avatar initial --}}
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/40
                                                    flex items-center justify-center flex-shrink-0
                                                    group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800/50 transition-colors">
                                            <span class="text-indigo-600 dark:text-indigo-400 font-bold text-sm">
                                                {{ strtoupper(substr($result['nom'], 0, 1)) }}{{ strtoupper(substr($result['prenom'] ?? '', 0, 1)) }}
                                            </span>
                                        </div>

                                        {{-- Infos --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-800 dark:text-white text-sm truncate">
                                                {{ $result['nom'] }} {{ $result['postnom'] }} {{ $result['prenom'] }}
                                            </div>
                                            <div class="flex items-center gap-3 mt-0.5">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    <i class="fa-solid fa-id-card mr-1 text-gray-400"></i>
                                                    {{ $result['matricule'] }}
                                                </span>
                                                @if($result['telephone'])
                                                    <span class="text-xs text-gray-400">·</span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        <i class="fa-solid fa-phone mr-1 text-gray-400"></i>
                                                        {{ $result['telephone'] }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Arrow --}}
                                        <div class="flex-shrink-0 text-gray-300 group-hover:text-indigo-500 transition-colors">
                                            <i class="fa-solid fa-chevron-right text-sm"></i>
                                        </div>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- ÉTUDIANT SÉLECTIONNÉ --}}
                @if($existingStudent)
                    <div class="rounded-2xl border-2 border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-800/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-circle-check text-green-600 dark:text-green-400 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wide mb-1">
                                        Étudiant sélectionné
                                    </p>
                                    <p class="font-bold text-gray-800 dark:text-white">
                                        {{ $existingStudent->nom }} {{ $existingStudent->postnom }} {{ $existingStudent->prenom }}
                                    </p>
                                    <div class="flex items-center gap-4 mt-1.5 text-sm text-gray-500 dark:text-gray-400">
                                        <span><i class="fa-solid fa-id-card mr-1.5"></i>{{ $existingStudent->matricule }}</span>
                                        @if($existingStudent->telephone)
                                            <span><i class="fa-solid fa-phone mr-1.5"></i>{{ $existingStudent->telephone }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button
                                    wire:click="$set('existingStudent', null)"
                                    class="px-3 py-2 text-xs font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400
                                           dark:hover:text-white bg-white dark:bg-gray-800 border border-gray-200
                                           dark:border-gray-600 rounded-lg transition"
                                >
                                    Changer
                                </button>
                                <button
                                    wire:click="nextStep"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700
                                           text-white rounded-lg text-sm font-semibold transition shadow-sm"
                                >
                                    Continuer
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- NOUVEL ÉTUDIANT --}}
                @if($isNewStudent)
                    <div class="space-y-5">
                        <div class="flex items-center gap-3 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                            <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                            <p class="text-sm text-amber-700 dark:text-amber-400">
                                Aucun étudiant trouvé. Remplissez le formulaire pour en créer un nouveau.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach([
                                ['model' => 'matricule', 'placeholder' => 'Matricule', 'type' => 'text', 'icon' => 'fa-id-card'],
                                ['model' => 'nom',       'placeholder' => 'Nom',       'type' => 'text', 'icon' => 'fa-user'],
                                ['model' => 'postnom',   'placeholder' => 'Postnom',   'type' => 'text', 'icon' => 'fa-user'],
                                ['model' => 'prenom',    'placeholder' => 'Prénom',    'type' => 'text', 'icon' => 'fa-user'],
                                ['model' => 'telephone', 'placeholder' => 'Téléphone', 'type' => 'text', 'icon' => 'fa-phone'],
                                ['model' => 'email',     'placeholder' => 'Email',     'type' => 'email','icon' => 'fa-envelope'],
                                ['model' => 'adresse',   'placeholder' => 'Adresse',   'type' => 'text', 'icon' => 'fa-location-dot'],
                            ] as $field)
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <i class="fa-solid {{ $field['icon'] }} text-gray-400 text-sm"></i>
                                    </div>
                                    <input
                                        type="{{ $field['type'] }}"
                                        wire:model="{{ $field['model'] }}"
                                        placeholder="{{ $field['placeholder'] }}"
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                    >
                                </div>
                            @endforeach

                            {{-- Genre + Date side by side --}}
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-venus-mars text-gray-400 text-sm"></i>
                                </div>
                                <select wire:model="genre"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition appearance-none">
                                    <option value="">Genre</option>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-calendar text-gray-400 text-sm"></i>
                                </div>
                                <input
                                    type="date"
                                    wire:model="date_naissance"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                                >
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button wire:click="nextStep"
                                class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                                       text-white rounded-xl font-semibold text-sm transition shadow-sm">
                                Continuer
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    @endif

    {{-- ======================== STEP 2 ======================== --}}
    @if($step == 2)
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

            <div class="px-6 pb-6 flex items-center justify-between">
                <button wire:click="previousStep"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-700
                           text-gray-700 dark:text-white rounded-xl font-semibold text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Retour
                </button>
                <button wire:click="nextStep"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-xl font-semibold text-sm transition shadow-sm">
                    Continuer
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>
    @endif

    {{-- ======================== STEP 3 ======================== --}}
    @if($step == 3)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-clipboard-check text-green-500 text-sm"></i>
                </div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Validation finale</h3>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Carte étudiant --}}
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-5 space-y-3">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-user-graduate text-indigo-500 text-sm"></i>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Étudiant</span>
                    </div>
                    @if($existingStudent)
                        <p class="font-bold text-gray-800 dark:text-white">
                            {{ $existingStudent->nom }} {{ $existingStudent->postnom }} {{ $existingStudent->prenom }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-id-card mr-2"></i>{{ $existingStudent->matricule }}
                        </p>
                        @if($existingStudent->telephone)
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-phone mr-2"></i>{{ $existingStudent->telephone }}
                            </p>
                        @endif
                    @else
                        <p class="font-bold text-gray-800 dark:text-white">{{ $nom }} {{ $postnom }} {{ $prenom }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-id-card mr-2"></i>{{ $matricule }}
                        </p>
                        @if($telephone)
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-phone mr-2"></i>{{ $telephone }}
                            </p>
                        @endif
                    @endif
                </div>

                {{-- Carte académique --}}
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-5 space-y-3">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="fa-solid fa-building-columns text-indigo-500 text-sm"></i>
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Académique</span>
                    </div>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Année :</span>
                        {{ optional($academicYears->find($academic_year_id))->name ?? '–' }}
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Faculté :</span>
                        {{ optional($faculties->find($faculty_id))->name ?? '–' }}
                    </p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Date :</span>
                        {{ $registration_date ? \Carbon\Carbon::parse($registration_date)->format('d/m/Y') : '–' }}
                    </p>
                </div>
            </div>

            {{-- Alerte de confirmation --}}
            <div class="mx-6 mb-4 flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                <i class="fa-solid fa-circle-info text-blue-500"></i>
                <p class="text-sm text-blue-700 dark:text-blue-400">
                    Veuillez vérifier les informations avant de confirmer l'inscription.
                </p>
            </div>

            <div class="px-6 pb-6 flex items-center justify-between">
                <button wire:click="previousStep"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 dark:bg-gray-700
                           text-gray-700 dark:text-white rounded-xl font-semibold text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Retour
                </button>
                <button wire:click="save"
                    wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 hover:bg-green-700
                           disabled:opacity-60 text-white rounded-xl font-semibold text-sm transition shadow-sm">
                    <span wire:loading.remove wire:target="save">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </span>
                    <span wire:loading wire:target="save">
                        <i class="fa-solid fa-circle-notch fa-spin"></i>
                    </span>
                    Confirmer l'inscription
                </button>
            </div>
        </div>
    @endif

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