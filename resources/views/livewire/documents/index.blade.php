<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-folder-open text-indigo-600"></i>
                </div>

                Gestion des documents

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Classement, recherche et historique des documents académiques générés
            </p>
        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total documents</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalDocuments }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-file-lines text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Générés aujourd'hui</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $totalToday }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-day text-emerald-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Révoqués</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $totalRevoked }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-ban text-red-600 text-lg"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- CARD --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">

        {{-- FILTRES : Rechercher + Classer --}}
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.400ms="search"
                    placeholder="Rechercher un code ou un étudiant..."
                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-900/40 text-sm text-gray-700 dark:text-gray-200
                           focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <select wire:model.live="type"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40
                       text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Tous les types</option>
                @foreach ($types as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>

            <select wire:model.live="statut"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40
                       text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                <option value="">Tous les statuts</option>
                <option value="valide">Valide</option>
                <option value="revoque">Révoqué</option>
            </select>

        </div>

        {{-- TABLE : Historique --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Code</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Concerné</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Émis par</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Statut</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse ($documents as $document)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $document->code }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-indigo-100 dark:bg-indigo-900/30
                                             text-indigo-700 dark:text-indigo-300 text-xs font-semibold">
                                    {{ $document->typeLabel() }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200">
                                {{ $document->subject_label }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $document->generatedBy?->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $document->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($document->is_revoked)
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-red-100 dark:bg-red-900/30
                                                 text-red-700 dark:text-red-300 text-xs font-semibold">
                                        Révoqué
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-emerald-100 dark:bg-emerald-900/30
                                                 text-emerald-700 dark:text-emerald-300 text-xs font-semibold">
                                        Valide
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">

                                    @php($url = $this->documentUrl($document))
                                    @if ($url)
                                        <a href="{{ $url }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-700
                                                   text-gray-700 dark:text-gray-200 text-xs font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                            <i class="fa-solid fa-download"></i>
                                            Télécharger
                                        </a>
                                    @endif

                                    @role('admin')
                                        @if (!$document->is_revoked)
                                            <button wire:click="revoke({{ $document->id }})"
                                                wire:confirm="Révoquer ce document ?"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-50 dark:bg-red-900/20
                                                       text-red-600 dark:text-red-400 text-xs font-semibold hover:bg-red-100 dark:hover:bg-red-900/40 transition">
                                                <i class="fa-solid fa-ban"></i>
                                                Révoquer
                                            </button>
                                        @endif
                                    @endrole

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                Aucun document trouvé.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-5 border-t border-gray-100 dark:border-gray-700">
            {{ $documents->links() }}
        </div>

    </div>

</div>