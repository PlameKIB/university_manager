<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            <i class="fa-solid fa-money-bill-wave text-indigo-600"></i>
            Gestion des frais académiques
        </h1>

        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Créez et gérez les frais de scolarité associés aux promotions.
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Nombre de frais
            </div>

            <div class="mt-2 text-3xl font-bold text-indigo-600">
                {{ $fees->count() }}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Total des frais
            </div>

            <div class="mt-2 text-3xl font-bold text-green-600">
                {{ number_format($fees->sum('amount'), 0, ',', ' ') }} $
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Promotions concernées
            </div>

            <div class="mt-2 text-3xl font-bold text-blue-600">
                {{ $fees->pluck('promotion_id')->unique()->count() }}
            </div>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">

            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                        @if($isEditing)
                            Modifier un frais
                        @else
                            Nouveau frais
                        @endif
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Configurez les frais académiques d'une promotion.
                    </p>
                </div>

                <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center">
                    <i class="fa-solid fa-money-bill-wave text-indigo-600 dark:text-indigo-400"></i>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- NAME --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Désignation
                    </label>

                    <input type="text" wire:model.live="name" placeholder="Ex : Frais d'inscription"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">

                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- AMOUNT --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Montant
                    </label>

                    <div class="relative">
                        <span class="absolute left-3 top-2.5 text-gray-500">$</span>

                        <input type="number" wire:model.live="amount" placeholder="5000"
                            class="w-full pl-8 rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    @error('amount')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- PROMOTION --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Promotion concernée
                    </label>

                    <select wire:model.live="promotion_id"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                        <option value="">Sélectionner une promotion</option>

                        @foreach($promotions as $promotion)
                            <option value="{{ $promotion->id }}">
                                {{ $promotion->name }} — {{ $promotion->department->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('promotion_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ANNEE ACADEMIQUE --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Année académique
                    </label>

                    <select wire:model.live="academic_year_id"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                        <option value="">Sélectionner</option>

                        @foreach($academicYears as $year)
                            <option value="{{ $year->id }}">
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('academic_year_id')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

            </div>

        </div>

        {{-- ACTIONS --}}
        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">

            @if($isEditing)

                <button wire:click="cancel"
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Annuler
                </button>

                <button wire:click="update"
                    class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white transition">
                    <i class="fa-solid fa-check mr-1"></i>
                    Mettre à jour
                </button>

            @else
                <button wire:click="save"
                    class="px-5 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white transition">
                    <i class="fa-solid fa-plus mr-1"></i>
                    Ajouter le frais
                </button>

            @endif

        </div>

    </div>

    {{-- LISTE --}}
    <div class="xl:col-span-2">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow overflow-hidden">

            {{-- RECHERCHE --}}
            <div class="p-4 border-b dark:border-gray-700">

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Rechercher un frais..."
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white">

            </div>

            {{-- TABLEAU --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 dark:bg-gray-900">

                        <tr>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Désignation
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Montant
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Promotion
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Département
                            </th>

                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase">
                                Année
                            </th>

                            <th class="px-6 py-3">
                                Actions
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($fees as $fee)

                            <tr class="border-t dark:border-gray-700">

                                <td class="px-6 py-4 dark:text-white">
                                    {{ $fee->name }}
                                </td>

                                <td class="px-6 py-4">

                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        {{ number_format($fee->amount, 0, ',', ' ') }} $
                                    </span>

                                </td>

                                <td class="px-6 py-4 dark:text-gray-300">
                                    {{ $fee->promotion->name }}
                                </td>

                                <td class="px-6 py-4 dark:text-gray-300">
                                    {{ $fee->promotion->department->name }}
                                </td>

                                <td class="px-6 py-4 dark:text-gray-300">
                                    {{ $fee->academicYear->name }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex gap-2">

                                        <button wire:click="edit({{ $fee->id }})"
                                            class="px-3 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-lg">
                                            Modifier
                                        </button>

                                        <button wire:click="delete({{ $fee->id }})"
                                            class="px-3 py-1 text-sm bg-red-100 text-red-700 rounded-lg">
                                            Supprimer
                                        </button>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="py-16 text-center">

                                    <i class="fa-solid fa-money-bill-wave text-5xl text-gray-300"></i>

                                    <p class="mt-4 text-gray-500">
                                        Aucun frais enregistré
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if(method_exists($fees, 'links'))
                <div class="p-4 border-t dark:border-gray-700">
                    {{ $fees->links() }}
                </div>
            @endif

        </div>

    </div>

</div>

</div>