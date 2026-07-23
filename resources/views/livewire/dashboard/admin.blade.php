<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-gauge-high text-indigo-600"></i>
                </div>

                Tableau de bord

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Vue d'ensemble de l'activité de l'université
                @if($activeYear)
                    &middot; Année académique <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $activeYear->name }}</span>
                @endif
            </p>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="flex flex-wrap items-center gap-2">

            <a href="{{ route('enrollment.create') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700
                       text-white rounded-xl font-semibold text-sm transition shadow-sm">
                <i class="fa-solid fa-user-plus"></i>
                Nouvelle inscription
            </a>

            <a href="{{ route('payment.create') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50
                       dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 border border-gray-200
                       dark:border-gray-700 rounded-xl font-semibold text-sm transition shadow-sm">
                <i class="fa-solid fa-credit-card text-emerald-600"></i>
                Nouveau paiement
            </a>

        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        {{-- STUDENTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Étudiants</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalStudents }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-users text-indigo-600 text-lg"></i>
                </div>
            </div>
            <a href="{{ route('student.index') }}" wire:navigate
                class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                Voir la liste <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- TEACHERS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enseignants</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalTeachers }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-amber-600 text-lg"></i>
                </div>
            </div>
            <a href="{{ route('admin.teacher.create') }}" wire:navigate
                class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-amber-600 hover:text-amber-700">
                Ajouter un enseignant <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- ACTIVE ENROLLMENTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Inscriptions actives</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ $activeEnrollments }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-id-card text-emerald-600 text-lg"></i>
                </div>
            </div>
            <a href="{{ route('enrollment.index') }}" wire:navigate
                class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                Voir les inscriptions <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        {{-- REVENUE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Revenus (ce mois)</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ number_format($monthRevenue, 2, ',', ' ') }} $
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar text-sky-600 text-lg"></i>
                </div>
            </div>
            <p class="mt-4 text-xs font-semibold text-gray-400 dark:text-gray-500">
                Total cumulé : {{ number_format($totalRevenue, 2, ',', ' ') }} $
            </p>
        </div>

    </div>

    {{-- CHART + PROMOTIONS --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

        {{-- REVENUE CHART --}}
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">Revenus des 6 derniers mois</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Total des paiements encaissés par mois</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-chart-column text-sky-600"></i>
                </div>
            </div>

            <div class="flex items-end justify-between gap-3 h-48">

                @foreach($monthlyRevenue as $month)

                    @php
                        $heightPct = $maxMonthlyRevenue > 0 ? max(4, ($month['amount'] / $maxMonthlyRevenue) * 100) : 4;
                    @endphp

                    <div class="flex-1 flex flex-col items-center justify-end h-full group">

                        <span class="text-[11px] font-semibold text-gray-500 dark:text-gray-400 mb-1 opacity-0
                                     group-hover:opacity-100 transition">
                            {{ number_format($month['amount'], 0, ',', ' ') }} $
                        </span>

                        <div class="w-full rounded-t-lg bg-gradient-to-t from-indigo-600 to-sky-500
                                    dark:from-indigo-500 dark:to-sky-400 transition-all duration-300
                                    hover:from-indigo-500 hover:to-sky-400"
                            style="height: {{ $heightPct }}%">
                        </div>

                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 mt-2">
                            {{ $month['label'] }}
                        </span>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- PROMOTIONS BREAKDOWN --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">

            <div class="flex items-center justify-between mb-6">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Étudiants par promotion</h3>
                <div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-layer-group text-indigo-600"></i>
                </div>
            </div>

            <div class="space-y-4">

                @forelse($promotionStats as $promotion)

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                                {{ $promotion->name }}
                            </span>
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                                {{ $promotion->enrollments_count }}
                            </span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">
                            <div class="h-full rounded-full bg-indigo-500"
                                style="width: {{ max(4, ($promotion->enrollments_count / $maxPromotionCount) * 100) }}%">
                            </div>
                        </div>
                    </div>

                @empty

                    <div class="text-center py-8">
                        <i class="fa-solid fa-layer-group text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-sm text-gray-400">Aucune promotion pour le moment</p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

    {{-- RECENT LISTS --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

        {{-- RECENT ENROLLMENTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Dernières inscriptions</h3>
                <a href="{{ route('enrollment.index') }}" wire:navigate
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                    Tout voir
                </a>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-700">

                @forelse($recentEnrollments as $enrollment)

                    <div class="px-6 py-4 flex items-center gap-4">

                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                    flex items-center justify-center flex-shrink-0">
                            <span class="text-indigo-600 font-bold text-xs">
                                {{ strtoupper(substr($enrollment->user->name ?? '?', 0, 1)) }}
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                {{ $enrollment->user->name ?? 'Étudiant inconnu' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                {{ $enrollment->promotion->name ?? '--' }}
                                &middot;
                                {{ \Illuminate\Support\Carbon::parse($enrollment->registration_date)->translatedFormat('d M Y') }}
                            </p>
                        </div>

                        @php
                            $statusStyles = [
                                'active' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30',
                                'completed' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30',
                                'abandoned' => 'bg-red-100 text-red-600 dark:bg-red-900/30',
                                'suspended' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/30',
                            ];
                            $statusLabels = [
                                'active' => 'Active',
                                'completed' => 'Terminée',
                                'abandoned' => 'Abandonnée',
                                'suspended' => 'Suspendue',
                            ];
                        @endphp

                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg flex-shrink-0
                                     {{ $statusStyles[$enrollment->status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ $statusLabels[$enrollment->status] ?? $enrollment->status }}
                        </span>

                    </div>

                @empty

                    <div class="px-6 py-12 text-center">
                        <i class="fa-solid fa-id-card text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-sm text-gray-400">Aucune inscription récente</p>
                    </div>

                @endforelse

            </div>

        </div>

        {{-- RECENT PAYMENTS --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Derniers paiements</h3>
                <a href="{{ route('admin.payments') }}" wire:navigate
                    class="text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                    Tout voir
                </a>
            </div>

            <div class="divide-y divide-gray-100 dark:divide-gray-700">

                @forelse($recentPayments as $payment)

                    <div class="px-6 py-4 flex items-center gap-4">

                        <div class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-900/30
                                    flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-receipt text-sky-600 text-sm"></i>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                                {{ $payment->enrollment->user->name ?? 'Étudiant inconnu' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                Reçu {{ $payment->receipt_number }}
                                &middot;
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
                        <p class="text-sm text-gray-400">Aucun paiement récent</p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>
