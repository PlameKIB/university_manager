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

            <div class="relative">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $name }}"
                         class="w-14 h-14 rounded-2xl object-cover border-2 border-indigo-200 dark:border-indigo-800">
                @else
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                        <span class="text-indigo-600 font-bold text-lg">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <div>

                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    {{ $name}}
                </h3>


            </div>

        </div>

        {{-- FORM --}}
        <form wire:submit="update" class="p-6 space-y-6">

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- NOM --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Noms
                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400 text-sm"></i>
                        </div>

                        <input type="text" wire:model="name" class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                    </div>

                    @error('name')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
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

            {{-- SECTION CHANGEMENT DE MOT DE PASSE --}}
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-lock text-indigo-600"></i>
                    Changer le mot de passe
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Laissez vides si vous ne voulez pas changer le mot de passe
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NOUVEAU MOT DE PASSE --}}
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Nouveau mot de passe
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fa-solid fa-key text-gray-400 text-sm"></i>
                            </div>

                            <input type="password" wire:model="password" placeholder="Minimum 8 caractères" 
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                          bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                          focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        @error('password')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- CONFIRMATION MOT DE PASSE --}}
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Confirmer le mot de passe
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                            </div>

                            <input type="password" wire:model="password_confirmation" placeholder="Répéter le mot de passe"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                          bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                          focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        @error('password_confirmation')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- SECTION PHOTO DE PROFIL --}}
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-image text-indigo-600"></i>
                    Photo de profil
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- APERÇU ACTUEL --}}
                    <div class="space-y-3">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Photo actuelle
                        </p>

                        <div class="relative w-full h-48 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center overflow-hidden">
                            @if($photo)
                                <img src="{{ $photo->temporaryUrl() }}" alt="Aperçu"
                                     class="w-full h-full object-cover">
                            @elseif($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-center">
                                    <i class="fa-solid fa-image text-gray-400 text-4xl mb-2 block"></i>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Aucune photo</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- TÉLÉCHARGER PHOTO --}}
                    <div class="space-y-3">
                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Télécharger une nouvelle photo
                        </p>

                        <div class="space-y-3">
                            <label for="photo" class="block relative cursor-pointer">
                                <div class="w-full h-48 rounded-xl border-2 border-dashed border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 flex items-center justify-center transition">
                                    <div class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up text-indigo-500 text-3xl mb-2 block"></i>
                                        <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                                            Cliquez ou déposez une image
                                        </p>
                                        <p class="text-xs text-indigo-500 dark:text-indigo-400 mt-1">
                                            PNG, JPG, GIF (Max 2MB)
                                        </p>
                                    </div>
                                </div>
                                <input type="file" wire:model="photo" id="photo" accept="image/*"
                                       class="hidden">
                            </label>

                            @error('photo')
                                <p class="text-xs text-red-500 flex items-center gap-2">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            @if($photo)
                                <div class="flex items-center justify-between bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
                                    <div class="flex items-center gap-2 text-sm text-green-700 dark:text-green-400">
                                        <i class="fa-solid fa-check-circle"></i>
                                        <span>Photo sélectionnée: {{ $photo->getClientOriginalName() }}</span>
                                    </div>
                                    <button type="button" wire:click="$set('photo', null)"
                                            class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition">
                                        <i class="fa-solid fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            <i class="fa-solid fa-info-circle mr-1"></i>
                            La photo sera redimensionnée automatiquement
                        </p>
                    </div>

                </div>
            </div>
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