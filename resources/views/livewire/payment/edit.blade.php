<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-pen text-amber-600"></i>
                </div>
                Modifier le paiement
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Reçu n° {{ $payment->receipt_number }}
            </p>
        </div>

        <a href="{{ route('payment.index') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gray-100 hover:bg-gray-200
                  dark:bg-gray-700 dark:hover:bg-gray-600
                  text-gray-700 dark:text-gray-200 rounded-xl font-semibold text-sm transition">
            <i class="fa-solid fa-arrow-left"></i>
            Retour
        </a>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- STUDENT / ENROLLMENT --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">

                <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-user-graduate text-indigo-600"></i>
                    Étudiant / Inscription
                </h3>

                <div class="space-y-4">

                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                            Rechercher un étudiant
                        </label>

                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                            </div>

                            <input type="text" wire:model.live.debounce.300ms="studentSearch"
                                placeholder="Nom, prénom ou matricule..." class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                       bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                       focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        </div>

                        {{-- RESULTS DROPDOWN --}}
                        @if($studentSearch && count($enrollmentResults) > 0 && !$selectedEnrollment)
                            <div class="absolute z-20 mt-2 w-full bg-white dark:bg-gray-800 border border-gray-100
                                        dark:border-gray-700 rounded-xl shadow-lg max-h-64 overflow-y-auto">

                                @foreach($enrollmentResults as $enrollment)
                                    <button type="button" wire:click="selectEnrollment({{ $enrollment->id }})" class="w-full text-left px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-900/40
                                                   flex items-center gap-3 transition border-b border-gray-50
                                                   dark:border-gray-700 last:border-0">

                                        <div class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                                    flex items-center justify-center flex-shrink-0">
                                            <span class="text-indigo-600 font-bold text-xs">
                                                {{ strtoupper(substr($enrollment->student->nom, 0, 1)) }}
                                            </span>
                                        </div>

                                        <div>
                                            <div class="text-sm font-semibold text-gray-800 dark:text-white">
                                                {{ $enrollment->student->nom }} {{ $enrollment->student->prenom }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $enrollment->student->matricule }} ·
                                                {{ $enrollment->faculty->name ?? '--' }} ·
                                                {{ $enrollment->academicYear->name ?? '--' }}
                                            </div>
                                        </div>

                                    </button>
                                @endforeach

                            </div>
                        @endif

                        @error('selectedEnrollment')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SELECTED STUDENT CARD --}}
                    @if($selectedEnrollment)
                        <div class="flex items-center justify-between p-4 rounded-xl bg-indigo-50 dark:bg-indigo-900/20
                                    border border-indigo-100 dark:border-indigo-800">

                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-full bg-indigo-600 flex items-center justify-center
                                            flex-shrink-0">
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($selectedEnrollment->user->name, 0, 1)) }}
                                    </span>
                                </div>

                                <div>
                                    <div class="font-semibold text-gray-800 dark:text-white text-sm">
                                        {{ $selectedEnrollment->user->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $selectedEnrollment->user->matricule }} ·
                                        {{ $selectedEnrollment->faculty->name ?? '--' }} ·
                                        {{ $selectedEnrollment->promotion->name ?? '--' }} ·
                                        {{ $selectedEnrollment->academicYear->name ?? '--' }}
                                    </div>
                                </div>
                            </div>

                            <button type="button" wire:click="clearEnrollment" class="w-9 h-9 rounded-lg bg-white dark:bg-gray-800 hover:bg-red-50
                                           dark:hover:bg-red-900/20 flex items-center justify-center
                                           text-gray-400 hover:text-red-600 transition">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>

                        </div>
                    @endif

                </div>

            </div>

            {{-- FEES / ITEMS --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">

                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-indigo-600"></i>
                        Frais à payer
                    </h3>

                    <button type="button" wire:click="addItem" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 hover:bg-indigo-100
                                   dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40
                                   text-indigo-600 rounded-lg font-semibold text-xs transition">
                        <i class="fa-solid fa-plus"></i>
                        Ajouter un frais
                    </button>
                </div>

                <div class="space-y-3">

                    @foreach($items as $index => $item)
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-gray-50 dark:bg-gray-900/40
                                    border border-gray-100 dark:border-gray-700">

                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-3">

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                                        Type de frais
                                    </label>

                                    <select wire:model.live="items.{{ $index }}.fee_id" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600
                                               bg-white dark:bg-gray-800 text-gray-800 dark:text-white text-sm
                                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                                        <option value="">-- Sélectionner --</option>
                                        @foreach($fees as $fee)
                                            <option value="{{ $fee->id }}">
                                                {{ $fee->name }} ({{ number_format($fee->amount, 2) }} $)
                                            </option>
                                        @endforeach
                                    </select>

                                    @error("items.{$index}.fee_id")
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                                        Montant ($)
                                    </label>

                                    <input type="number" step="0.01" min="0" wire:model.live="items.{{ $index }}.amount" placeholder="0.00" class="w-full px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600
                                               bg-white dark:bg-gray-800 text-gray-800 dark:text-white text-sm
                                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                                    @error("items.{$index}.amount")
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <button type="button" wire:click="removeItem({{ $index }})" @if(count($items) === 1) disabled @endif class="w-9 h-9 mt-6 rounded-lg bg-red-50 hover:bg-red-100
                                           dark:bg-red-900/20 dark:hover:bg-red-900/40
                                           flex items-center justify-center text-red-600 transition
                                           disabled:opacity-30 disabled:cursor-not-allowed flex-shrink-0">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>

                        </div>
                    @endforeach

                </div>

            </div>

        </div>

        {{-- RIGHT COLUMN — SUMMARY --}}
        <div class="lg:col-span-1">

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm sticky top-6">

                <h3 class="text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2 mb-5">
                    <i class="fa-solid fa-file-invoice-dollar text-indigo-600"></i>
                    Résumé du paiement
                </h3>

                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                            N° de reçu
                        </label>

                        <input type="text" wire:model="receipt_number" placeholder="Généré automatiquement"
                            readonly class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-100 dark:bg-gray-900 text-gray-500 dark:text-gray-400 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                            Date de paiement
                        </label>

                        <input type="date" wire:model="payment_date" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

                        @error('payment_date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
                            Note (optionnel)
                        </label>

                        <textarea wire:model="note" rows="3" placeholder="Remarque..." class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                                   focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"></textarea>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                Montant total
                            </span>

                            <span class="text-2xl font-bold text-indigo-600">
                                {{ number_format($totalAmount, 2, ',', ' ') }} $
                            </span>
                        </div>
                    </div>

                    <button type="submit" wire:loading.attr="disabled" wire:target="save" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5
                                   bg-amber-600 hover:bg-amber-700 disabled:opacity-60
                                   text-white rounded-xl font-semibold text-sm transition shadow-sm">
                        <i class="fa-solid fa-circle-notch fa-spin" wire:loading wire:target="save"></i>
                        <i class="fa-solid fa-check" wire:loading.remove wire:target="save"></i>
                        Mettre à jour le paiement
                    </button>

                </div>

            </div>

        </div>

    </form>

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

    $wire.on('error', (event) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: event.message,
            showConfirmButton: false,
            timer: 3000,
            background: '#1f2937',
            color: '#fff'
        });
    });
</script>
@endscript