<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-user-pen text-amber-600"></i>
                </div>

                Modifier l'étudiant

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Mise à jour des informations personnelles de l'étudiant
            </p>
        </div>

        <a href="{{ route('student.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 border border-gray-200 dark:border-gray-700
                  bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700
                  text-gray-700 dark:text-white rounded-xl text-sm font-medium transition">

            <i class="fa-solid fa-arrow-left"></i>
            Retour

        </a>

    </div>

    {{-- CARD --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- TOP --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-4">

            <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30
                        flex items-center justify-center">

                <span class="text-indigo-600 font-bold text-lg">
                    {{ strtoupper(substr($nom, 0, 1)) }}
                    {{ strtoupper(substr($prenom ?? '', 0, 1)) }}
                </span>

            </div>

            <div>

                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $nom }} {{ $postnom }} {{ $prenom }}
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Matricule : {{ $matricule }}
                </p>

            </div>

        </div>

        {{-- FORM --}}
        <form wire:submit="update" class="p-6 space-y-6">

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- MATRICULE --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Matricule
                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-id-card text-gray-400 text-sm"></i>
                        </div>

                        <input type="text" wire:model="matricule" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                    </div>

                    @error('matricule')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NOM --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nom
                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400 text-sm"></i>
                        </div>

                        <input type="text" wire:model="nom" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                    </div>

                    @error('nom')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- POSTNOM --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Postnom
                    </label>

                    <input type="text" wire:model="postnom" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                {{-- PRENOM --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Prénom
                    </label>

                    <input type="text" wire:model="prenom" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                {{-- TELEPHONE --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Téléphone
                    </label>

                    <input type="text" wire:model="telephone" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                {{-- EMAIL --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email
                    </label>

                    <input type="email" wire:model="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                {{-- GENRE --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Genre
                    </label>

                    <select wire:model="genre" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">Sélectionner</option>
                        <option value="M">Masculin</option>
                        <option value="F">Féminin</option>
                    </select>
                </div>

                {{-- DATE --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Date de naissance
                    </label>

                    <input type="date" wire:model="date_naissance" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                {{-- ADRESSE --}}
                <div class="space-y-2 md:col-span-2 lg:col-span-1">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Adresse
                    </label>

                    <input type="text" wire:model="adresse" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">

                <a href="{{ route('student.index') }}" class="px-5 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                          text-gray-700 dark:text-gray-300 text-sm font-medium
                          hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                    Annuler

                </a>

                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-xl font-semibold text-sm transition shadow-sm">

                    <i class="fa-solid fa-floppy-disk"></i>

                    Enregistrer les modifications

                </button>

            </div>

        </form>

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