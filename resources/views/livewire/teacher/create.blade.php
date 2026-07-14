<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-indigo-600"></i>
                </div>

                Enseignants

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Gestion des enseignants du système
            </p>

        </div>

    </div>

    {{-- FORM CARD --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- TOP --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                <i class="fa-solid fa-id-card text-indigo-600"></i>
            </div>

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    {{ $isEditing ? 'Modifier l’enseignant' : 'Nouvel enseignant' }}
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Complétez les informations ci-dessous
                </p>
            </div>

        </div>

        {{-- FORM --}}
        <form wire:submit="{{ $isEditing ? 'update' : 'save' }}" class="p-6 space-y-6">

            {{-- GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                {{-- NOM --}}
                <div class="space-y-2">

                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nom
                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-user text-gray-400 text-sm"></i>
                        </div>

                        <input
                            type="text"
                            wire:model="name"
                            placeholder="Nom complet"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        >

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

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-phone text-gray-400 text-sm"></i>
                        </div>

                        <input
                            type="text"
                            wire:model="telephone"
                            placeholder="+243..."
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        >

                    </div>

                </div>

                {{-- EMAIL --}}
                <div class="space-y-2">

                    <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email
                    </label>

                    <div class="relative">

                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fa-solid fa-envelope text-gray-400 text-sm"></i>
                        </div>

                        <input
                            type="email"
                            wire:model="email"
                            placeholder="email@example.com"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                        >

                    </div>

                    @error('email')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                {{-- PASSWORD (création uniquement) --}}
                @unless($isEditing)
                    <div class="space-y-2">

                        <label class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Mot de passe
                        </label>

                        <div class="relative">

                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 text-sm"></i>
                            </div>

                            <input
                                type="password"
                                wire:model="password"
                                placeholder="••••••••"
                                class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                       bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                       focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            >

                        </div>

                        @error('password')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                @endunless

            </div>

            {{-- ACTIONS --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">

                @if($isEditing)
                    <button
                        type="button"
                        wire:click="$set('isEditing', false)"
                        class="px-5 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               text-gray-700 dark:text-gray-300 text-sm font-medium
                               hover:bg-gray-50 dark:hover:bg-gray-700 transition"
                    >
                        Annuler
                    </button>
                @endif

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-xl font-semibold text-sm transition shadow-sm"
                >

                    <i class="fa-solid fa-floppy-disk"></i>

                    {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}

                </button>

            </div>

        </form>

    </div>

    {{-- LISTE DES ENSEIGNANTS --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">

            <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                <i class="fa-solid fa-list text-indigo-600"></i>
            </div>

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Liste des enseignants
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    {{ $teachers->count() }} enseignant(s) enregistré(s)
                </p>
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Matricule</th>
                        <th class="px-6 py-3 text-left font-semibold">Nom complet</th>
                        <th class="px-6 py-3 text-left font-semibold">Email</th>
                        <th class="px-6 py-3 text-left font-semibold">Téléphone</th>
                        <th class="px-6 py-3 text-right font-semibold">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/30 transition">

                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium">
                                {{ $teacher->matricule }}
                            </td>

                            <td class="px-6 py-4 text-gray-800 dark:text-white">
                                {{ $teacher->name }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $teacher->email }}
                            </td>

                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $teacher->telephone ?: '—' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <button
                                        wire:click="edit({{ $teacher->id }})"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg
                                               bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600
                                               hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition"
                                        title="Modifier"
                                    >
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </button>

                                    <button
                                        wire:click="delete({{ $teacher->id }})"
                                        wire:confirm="Voulez-vous vraiment supprimer cet enseignant ?"
                                        class="w-9 h-9 flex items-center justify-center rounded-lg
                                               bg-red-50 dark:bg-red-900/30 text-red-600
                                               hover:bg-red-100 dark:hover:bg-red-900/50 transition"
                                        title="Supprimer"
                                    >
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">
                                Aucun enseignant enregistré pour le moment.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

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