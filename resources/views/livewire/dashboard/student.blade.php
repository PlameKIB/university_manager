<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                <i class="fa-solid fa-user-graduate text-indigo-600"></i>
            </div>
            Mon tableau de bord
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Bienvenue, {{ auth()->user()->name }}
        </p>
    </div>

    @if(!$enrollment)

        {{-- NO ENROLLMENT --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-12 text-center shadow-sm">
            <i class="fa-solid fa-id-card text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
            <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300">Aucune inscription trouvée</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Contactez l'administration pour finaliser votre inscription.
            </p>
        </div>

    @else

        {{-- ENROLLMENT INFO BAR --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm
                    flex flex-wrap items-center gap-x-8 gap-y-2">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Promotion</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $enrollment->promotion->name ?? '--' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Département</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $enrollment->department->name ?? '--' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Année académique</p>
                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $enrollment->academicYear->name ?? '--' }}</p>
            </div>
            <div class="ml-auto flex flex-wrap items-center gap-2">

                <a href="{{ route('releve.show', $enrollment) }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700
                           text-white rounded-xl font-semibold text-sm transition shadow-sm">
                    <i class="fa-solid fa-file-lines"></i>
                    Mon relevé (PDF)
                </a>

                @if($enrollment->status === 'active')
                    <a href="{{ route('documents.attestation_frequentation', $enrollment) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50
                               dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200
                               dark:border-gray-700 rounded-xl font-semibold text-sm transition shadow-sm">
                        <i class="fa-solid fa-file-shield text-sky-600"></i>
                        Attestation de fréquentation
                    </a>
                @endif

                @if(($decision ?? null) === 'ADMIS(E)')
                    <a href="{{ route('documents.attestation_reussite', $enrollment) }}" target="_blank"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 hover:bg-gray-50
                               dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200
                               dark:border-gray-700 rounded-xl font-semibold text-sm transition shadow-sm">
                        <i class="fa-solid fa-award text-emerald-600"></i>
                        Attestation de réussite
                    </a>
                @endif

            </div>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Cours suivis</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalCourses }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-book text-indigo-600 text-lg"></i>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                    {{ $gradedCourses }} coté(s) sur {{ $totalCourses }}
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Moyenne générale</p>
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $moyenneSur20 }} / 20</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-chart-line text-sky-600 text-lg"></i>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                    {{ $pourcentageGeneral }}%
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mention</p>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white mt-1">{{ $mention }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-award text-amber-600 text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Solde à payer</p>
                        <h3 class="text-2xl font-bold {{ $balance > 0 ? 'text-red-600' : 'text-emerald-600' }} mt-1">
                            {{ number_format($balance, 2, ',', ' ') }} $
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <i class="fa-solid fa-sack-dollar text-red-600 text-lg"></i>
                    </div>
                </div>
                <p class="mt-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                    Payé : {{ number_format($totalPaid, 2, ',', ' ') }} $ / {{ number_format($totalFees, 2, ',', ' ') }} $
                </p>
            </div>

        </div>

        {{-- GRADES + PAYMENTS --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

            {{-- MY GRADES --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">Mes cours &amp; notes</h3>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($lines as $line)

                        <div class="px-6 py-4 flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30
                                        flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-book-open text-indigo-600 text-sm"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                    {{ $line->course->name ?? '--' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $line->credit }} crédit(s)
                                </p>
                            </div>

                            @if($line->is_graded)
                                <span class="text-sm font-bold text-gray-800 dark:text-white flex-shrink-0">
                                    {{ $line->cote_finale }} / {{ $line->bareme_total }}
                                </span>
                            @else
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg bg-amber-100
                                             text-amber-600 dark:bg-amber-900/30 flex-shrink-0">
                                    Non coté
                                </span>
                            @endif

                        </div>

                    @empty

                        <div class="px-6 py-12 text-center">
                            <i class="fa-solid fa-book text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-sm text-gray-400">Aucun cours pour cette année académique</p>
                        </div>

                    @endforelse

                </div>

            </div>

            {{-- MY PAYMENTS --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">Mes derniers paiements</h3>
                </div>

                <div class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($recentPayments as $payment)

                        <div class="px-6 py-4 flex items-center gap-4">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30
                                        flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-receipt text-emerald-600 text-sm"></i>
                            </div>

                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                    Reçu {{ $payment->receipt_number }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ \Illuminate\Support\Carbon::parse($payment->payment_date)->translatedFormat('d M Y') }}
                                </p>
                            </div>

                            <span class="text-sm font-bold text-emerald-600 flex-shrink-0">
                                {{ number_format($payment->total_amount, 2, ',', ' ') }} $
                            </span>

                        </div>

                    @empty

                        <div class="px-6 py-12 text-center">
                            <i class="fa-solid fa-receipt text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                            <p class="text-sm text-gray-400">Aucun paiement enregistré</p>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    @endif

</div>
