<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-users text-indigo-600"></i>
                </div>
                Liste des inscriptions
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Gestion des étudiants inscrits et suivi académique
            </p>
        </div>

        <a href="{{ route('enrollment.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                  text-white rounded-xl font-semibold text-sm transition shadow-sm">
            <i class="fa-solid fa-plus"></i>
            Nouvelle inscription
        </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total inscriptions</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $inscriptions->total() }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-user-graduate text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Actives</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">
                        {{ $activeCount ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-circle-check text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Filières</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $facultyCount ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-layer-group text-blue-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Année active</p>
                    <h3 class="text-lg font-bold text-amber-600 mt-1">
                        {{ $currentYear->name ?? '--' }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-days text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- TOP BAR --}}
        <div
            class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row lg:items-center gap-4 lg:justify-between">

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Inscriptions académiques
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Liste complète des étudiants inscrits
                </p>
            </div>

            {{-- SEARCH + FILTER --}}
            <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                    </div>

                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher..." class="w-full md:w-72 pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <select wire:model.live="academic_year_id" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <option value="">Toutes les années</option>

                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">
                            {{ $year->name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        {{-- TABLE CONTENT --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Étudiant
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Matricule
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Filière
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Promotion
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Année
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($inscriptions as $inscription)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            {{-- STUDENT --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                                        flex items-center justify-center flex-shrink-0">

                                        <span class="text-indigo-600 font-bold text-sm">
                                            {{ strtoupper(substr($inscription->user->name, 0, 1)) }}
                                        </span>

                                    </div>

                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white text-sm">
                                            {{ $inscription->user->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="fa-solid fa-phone mr-1"></i>
                                            {{ $inscription->user->telephone ?? 'Aucun numéro' }}
                                        </div>
                                    </div>

                                </div>

                            </td>

                            {{-- MATRICULE --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                                     bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                     text-xs font-semibold">
                                    <i class="fa-solid fa-id-card"></i>
                                    {{ $inscription->user->matricule }}
                                </span>
                            </td>

                            {{-- FILIERE --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $inscription->faculty->name ?? '--' }}
                                </span>
                            </td>

                            {{-- PROMOTION --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $inscription->promotion->name ?? '--' }}
                                </span>
                            </td>

                            {{-- YEAR --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg
                                                     bg-indigo-50 dark:bg-indigo-900/20
                                                     text-indigo-600 dark:text-indigo-400 text-xs font-semibold">
                                    {{ $inscription->academicYear->name ?? '--' }}
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="" class="w-9 h-9 rounded-lg bg-blue-50 hover:bg-blue-100
                                                      dark:bg-blue-900/20 dark:hover:bg-blue-900/40
                                                      flex items-center justify-center text-blue-600 transition">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('enrollment.edit', $inscription->id) }}" class="w-9 h-9 rounded-lg bg-amber-50 hover:bg-amber-100
                                                      dark:bg-amber-900/20 dark:hover:bg-amber-900/40
                                                      flex items-center justify-center text-amber-600 transition">
                                        <i class="fa-solid fa-pen text-sm"></i>
                                    </a>

                                    <a href="{{ route('releve.show', $inscription->id) }}" target="_blank" title="Relevé de notes (PDF)" class="w-9 h-9 rounded-lg bg-green-50 hover:bg-green-100
                                                      dark:bg-green-900/20 dark:hover:bg-green-900/40
                                                      flex items-center justify-center text-green-600 transition">
                                        <i class="fa-solid fa-print text-sm"></i>
                                    </a>

                                    <a href="{{ route('documents.attestation_frequentation', $inscription->id) }}" target="_blank" title="Attestation de fréquentation" class="w-9 h-9 rounded-lg bg-sky-50 hover:bg-sky-100
                                                      dark:bg-sky-900/20 dark:hover:bg-sky-900/40
                                                      flex items-center justify-center text-sky-600 transition">
                                        <i class="fa-solid fa-file-shield text-sm"></i>
                                    </a>

                                    <a href="{{ route('documents.attestation_reussite', $inscription->id) }}" target="_blank" title="Attestation de réussite" class="w-9 h-9 rounded-lg bg-purple-50 hover:bg-purple-100
                                                      dark:bg-purple-900/20 dark:hover:bg-purple-900/40
                                                      flex items-center justify-center text-purple-600 transition">
                                        <i class="fa-solid fa-award text-sm"></i>
                                    </a>

                                    <button wire:click="delete({{ $inscription->id }})"
                                        wire:confirm="Voulez-vous vraiment supprimer cette inscription ?" class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100
                                                       dark:bg-red-900/20 dark:hover:bg-red-900/40
                                                       flex items-center justify-center text-red-600 transition">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-20 h-20 rounded-2xl bg-gray-100 dark:bg-gray-700
                                                        flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-folder-open text-3xl text-gray-400"></i>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                        Aucune inscription trouvée
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Commencez par créer une nouvelle inscription.
                                    </p>

                                    <a href="{{ route('enrollment.create') }}" class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                                                      text-white rounded-xl font-semibold text-sm transition shadow-sm">
                                        <i class="fa-solid fa-plus"></i>
                                        Nouvelle inscription
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($inscriptions->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $inscriptions->links() }}
            </div>
        @endif

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