<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-indigo-600"></i>
                </div>
                Détail du paiement
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Reçu n° {{ $payment->receipt_number }}
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('payment.receipt', $payment->id) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                      text-white rounded-xl font-semibold text-sm transition shadow-sm">
                <i class="fa-solid fa-print"></i>
                Imprimer le reçu
            </a>

            <a href="{{ route('payment.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200
                      dark:bg-gray-700 dark:hover:bg-gray-600
                      text-gray-700 dark:text-gray-200 rounded-xl font-semibold text-sm transition">
                <i class="fa-solid fa-arrow-left"></i>
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STUDENT --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">

                <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-user-graduate text-indigo-600"></i>
                    Étudiant
                </h3>

                <div class="flex items-center gap-4">

                    <div class="w-14 h-14 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                flex items-center justify-center flex-shrink-0">
                        <span class="text-indigo-600 font-bold text-lg">
                            {{ strtoupper(substr($payment->enrollment->user->name, 0, 1)) }}
                        </span>
                    </div>

                    <div class="flex-1">
                        <div class="font-semibold text-gray-800 dark:text-white text-base">
                            {{ $payment->enrollment->user->name }}
                        </div>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 dark:text-gray-400 mt-2">
                            <span><i class="fa-solid fa-id-card mr-1"></i>{{ $payment->enrollment->user->matricule }}</span>
                            <span><i class="fa-solid fa-phone mr-1"></i>{{ $payment->enrollment->user->telephone ?? 'Aucun numéro' }}</span>
                        </div>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-5 pt-5 border-t border-gray-100 dark:border-gray-700">

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Filière</p>
                        <p class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $payment->enrollment->faculty->name ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Promotion</p>
                        <p class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $payment->enrollment->promotion->name ?? '--' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Année académique</p>
                        <p class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $payment->enrollment->academicYear->name ?? '--' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- ITEMS --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

                <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-600"></i>
                        Détail des frais payés
                    </h3>
                </div>

                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Type de frais
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                Montant
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($payment->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $item->fee->name ?? '--' }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-semibold text-gray-800 dark:text-white">
                                    {{ number_format($item->amount, 2, ',', ' ') }} $
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot class="bg-gray-50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700">
                        <tr>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800 dark:text-white">
                                Total
                            </td>
                            <td class="px-6 py-4 text-right text-base font-bold text-indigo-600">
                                {{ number_format($payment->total_amount, 2, ',', ' ') }} $
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>

            @if($payment->note)
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-3">
                        <i class="fa-solid fa-note-sticky text-indigo-600"></i>
                        Note
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $payment->note }}
                    </p>
                </div>
            @endif

        </div>

        {{-- RIGHT COLUMN --}}
        <div class="lg:col-span-1">

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm sticky top-6">

                <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-circle-info text-indigo-600"></i>
                    Informations
                </h3>

                <div class="space-y-4">

                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">N° de reçu</span>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                     bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                     text-xs font-semibold">
                            {{ $payment->receipt_number }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Date de paiement</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Nombre de frais</span>
                        <span class="text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $payment->items->count() }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between pt-3">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Montant total</span>
                        <span class="text-2xl font-bold text-green-600">
                            {{ number_format($payment->total_amount, 2, ',', ' ') }} $
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>