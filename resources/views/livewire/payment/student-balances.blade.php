<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

            <div class="w-11 h-11 rounded-xl bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center">
                <i class="fa-solid fa-scale-balanced text-purple-600"></i>
            </div>

            Soldes des étudiants

        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Situation financière de chaque étudiant inscrit
        </p>
    </div>

    {{-- CARD --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">

        {{-- FILTRES --}}
        <div class="p-5 border-b border-gray-100 dark:border-gray-700 flex flex-col md:flex-row gap-3">

            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" wire:model.live.debounce.400ms="search"
                    placeholder="Rechercher par nom ou matricule..."
                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700
                           bg-gray-50 dark:bg-gray-900/40 text-sm text-gray-700 dark:text-gray-200
                           focus:ring-2 focus:ring-purple-500 focus:outline-none">
            </div>

            <select wire:model.live="academic_year_id"
                class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40
                       text-sm text-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-purple-500 focus:outline-none">
                <option value="">Toutes les années</option>
                @foreach ($academicYears as $year)
                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                @endforeach
            </select>

            <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700
                          bg-gray-50 dark:bg-gray-900/40 text-sm text-gray-700 dark:text-gray-200 cursor-pointer">
                <input type="checkbox" wire:model.live="onlyUnpaid" class="rounded text-purple-600 focus:ring-purple-500">
                Solde restant uniquement
            </label>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Étudiant</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Promotion</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Année académique</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Frais dus</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Payé</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Solde</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse ($enrollments as $enrollment)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-full bg-purple-100 dark:bg-purple-900/30
                                                flex items-center justify-center flex-shrink-0">
                                        <span class="text-purple-600 font-bold text-sm">
                                            {{ strtoupper(substr($enrollment->user->name ?? '?', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white text-sm">
                                            {{ $enrollment->user->name ?? '—' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $enrollment->user->matricule ?? '—' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200">
                                {{ $enrollment->promotion->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $enrollment->academicYear->name ?? '—' }}
                            </td>

                            <td class="px-6 py-4 text-right text-sm text-gray-700 dark:text-gray-200">
                                {{ number_format($enrollment->total_fees, 2, ',', ' ') }} $
                            </td>

                            <td class="px-6 py-4 text-right text-sm text-emerald-600 font-semibold">
                                {{ number_format($enrollment->total_paid, 2, ',', ' ') }} $
                            </td>

                            <td class="px-6 py-4 text-right">
                                <span class="font-bold {{ $enrollment->balance > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    {{ number_format($enrollment->balance, 2, ',', ' ') }} $
                                </span>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                Aucun étudiant trouvé.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-5 border-t border-gray-100 dark:border-gray-700">
            {{ $enrollments->links() }}
        </div>

    </div>

</div>