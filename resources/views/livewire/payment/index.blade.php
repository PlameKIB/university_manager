<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-indigo-600"></i>
                </div>
                Liste des paiements
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Suivi des paiements et reçus des étudiants
            </p>
        </div>

        <a href="{{ route('payment.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                  text-white rounded-xl font-semibold text-sm transition shadow-sm">
            <i class="fa-solid fa-plus"></i>
            Nouveau paiement
        </a>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total paiements</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $payments->total() }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Montant total</p>
                    <h3 class="text-2xl font-bold text-green-600 mt-1">
                        {{ number_format($totalAmount ?? 0, 2, ',', ' ') }} $
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-sack-dollar text-green-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Paiements aujourd'hui</p>
                    <h3 class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $todayCount ?? 0 }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-calendar-day text-blue-600 text-lg"></i>
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
                    Paiements enregistrés
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Liste complète des reçus de paiement
                </p>
            </div>

            {{-- SEARCH + FILTER --}}
            <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                    </div>

                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Rechercher (nom, matricule, n° reçu)..." class="w-full md:w-72 pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

                <input type="date" wire:model.live="payment_date" class="px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

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
                            N° Reçu
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Étudiant
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Filière / Promotion
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Frais payés
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Date
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Montant
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($payments as $payment)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            {{-- RECEIPT --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                                     bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                                     text-xs font-semibold">
                                    <i class="fa-solid fa-hashtag"></i>
                                    {{ $payment->receipt_number }}
                                </span>
                            </td>

                            {{-- STUDENT --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    <div class="w-11 h-11 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                                        flex items-center justify-center flex-shrink-0">

                                        <span class="text-indigo-600 font-bold text-sm">
                                            {{ strtoupper(substr($payment->enrollment->user->name, 0, 1)) }}
                                        </span>

                                    </div>

                                    <div>
                                        <div class="font-semibold text-gray-800 dark:text-white text-sm">
                                            {{ $payment->enrollment->user->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            <i class="fa-solid fa-id-card mr-1"></i>
                                            {{ $payment->enrollment->user->matricule }}
                                        </div>
                                    </div>

                                </div>

                            </td>

                            {{-- FILIERE / PROMOTION --}}
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                                    {{ $payment->enrollment->faculty->name ?? '--' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $payment->enrollment->promotion->name ?? '--' }}
                                </div>
                            </td>

                            {{-- FEES / ITEMS --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1 max-w-[220px]">
                                    @foreach($payment->items->take(2) as $item)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md
                                                             bg-purple-50 dark:bg-purple-900/20
                                                             text-purple-600 dark:text-purple-400 text-xs font-medium">
                                            {{ $item->fee->name ?? '--' }}
                                        </span>
                                    @endforeach

                                    @if($payment->items->count() > 2)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md
                                                             bg-gray-100 dark:bg-gray-700
                                                             text-gray-500 dark:text-gray-400 text-xs font-medium">
                                            +{{ $payment->items->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            </td>

                            {{-- DATE --}}
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                                </span>
                            </td>

                            {{-- AMOUNT --}}
                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg
                                                     bg-green-50 dark:bg-green-900/20
                                                     text-green-600 dark:text-green-400 text-xs font-bold">
                                    {{ number_format($payment->total_amount, 2, ',', ' ') }} $
                                </span>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('payment.show', $payment->id) }}" class="w-9 h-9 rounded-lg bg-blue-50 hover:bg-blue-100
                                                      dark:bg-blue-900/20 dark:hover:bg-blue-900/40
                                                      flex items-center justify-center text-blue-600 transition">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('payment.receipt', $payment->id) }}" target="_blank" class="w-9 h-9 rounded-lg bg-indigo-50 hover:bg-indigo-100
                                                      dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40
                                                      flex items-center justify-center text-indigo-600 transition">
                                        <i class="fa-solid fa-print text-sm"></i>
                                    </a>

                                    <a href="{{ route('payment.edit', $payment->id) }}" class="w-9 h-9 rounded-lg bg-amber-50 hover:bg-amber-100
                                                      dark:bg-amber-900/20 dark:hover:bg-amber-900/40
                                                      flex items-center justify-center text-amber-600 transition">
                                        <i class="fa-solid fa-pen text-sm"></i>
                                    </a>

                                    <button wire:click="delete({{ $payment->id }})"
                                        wire:confirm="Voulez-vous vraiment supprimer ce paiement ?" class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100
                                                       dark:bg-red-900/20 dark:hover:bg-red-900/40
                                                       flex items-center justify-center text-red-600 transition">
                                        <i class="fa-solid fa-trash text-sm"></i>
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-20 h-20 rounded-2xl bg-gray-100 dark:bg-gray-700
                                                        flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-folder-open text-3xl text-gray-400"></i>
                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                        Aucun paiement trouvé
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Commencez par enregistrer un nouveau paiement.
                                    </p>

                                    <a href="{{ route('payment.create') }}" class="mt-5 inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                                                      text-white rounded-xl font-semibold text-sm transition shadow-sm">
                                        <i class="fa-solid fa-plus"></i>
                                        Nouveau paiement
                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($payments->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $payments->links() }}
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