<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-indigo-600"></i>
                </div>
                Journal d'Activité
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Suivi complet de toutes les actions du système
            </p>
        </div>
    </div>

    {{-- FILTRES --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Recherche -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Rechercher
                </label>
                <input
                    type="text"
                    wire:model.live="search"
                    placeholder="Description, modèle..."
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                />
            </div>

            <!-- Action -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Action
                </label>
                <select
                    wire:model.live="action"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
                    <option value="">Toutes les actions</option>
                    @foreach($actions as $act)
                        <option value="{{ $act }}">
                            <i class="fa-solid"></i> {{ ucfirst($act) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Modèle -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Modèle
                </label>
                <select
                    wire:model.live="model"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
                    <option value="">Tous les modèles</option>
                    @foreach($models as $mod)
                        <option value="{{ $mod }}">{{ $mod }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Utilisateur -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Utilisateur
                </label>
                <select
                    wire:model.live="user"
                    class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $userId => $userName)
                        <option value="{{ $userId }}">{{ $userName }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Bouton Réinitialiser -->
            <div class="flex items-end">
                <button
                    wire:click="resetFilters"
                    class="w-full px-4 py-2 bg-gray-400 hover:bg-gray-500 dark:bg-gray-600 dark:hover:bg-gray-700 text-white rounded-lg font-semibold transition text-sm"
                >
                    <i class="fa-solid fa-rotate-left mr-2"></i>
                    Réinitialiser
                </button>
            </div>
        </div>
    </div>

    {{-- TABLEAU DES ACTIVITÉS --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" wire:click="sortBy('created_at')">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-calendar-days text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Date/Heure
                                    @if($sort === 'created_at')
                                        <i class="fa-solid {{ $direction === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }} ml-1"></i>
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" wire:click="sortBy('user_id')">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-user text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Utilisateur
                                    @if($sort === 'user_id')
                                        <i class="fa-solid {{ $direction === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }} ml-1"></i>
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" wire:click="sortBy('action')">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-bolt text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Action
                                    @if($sort === 'action')
                                        <i class="fa-solid {{ $direction === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }} ml-1"></i>
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition" wire:click="sortBy('model')">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-cube text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Modèle
                                    @if($sort === 'model')
                                        <i class="fa-solid {{ $direction === 'asc' ? 'fa-arrow-up' : 'fa-arrow-down' }} ml-1"></i>
                                    @endif
                                </span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-message text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Description</span>
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-globe text-gray-500 dark:text-gray-400"></i>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">IP</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($activities as $activity)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-clock text-gray-400"></i>
                                    {{ $activity->created_at->format('d/m/Y H:i:s') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($activity->user)
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 rounded-lg text-xs font-semibold">
                                        <i class="fa-solid fa-user-circle"></i>
                                        {{ $activity->user->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $actionData = [
                                        'create' => ['color' => 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300', 'icon' => 'fa-plus'],
                                        'update' => ['color' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300', 'icon' => 'fa-pen'],
                                        'delete' => ['color' => 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300', 'icon' => 'fa-trash'],
                                        'view' => ['color' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300', 'icon' => 'fa-eye'],
                                        'login' => ['color' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300', 'icon' => 'fa-arrow-right-to-bracket'],
                                        'logout' => ['color' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300', 'icon' => 'fa-arrow-right-from-bracket'],
                                    ];
                                    $data = $actionData[$activity->action] ?? ['color' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300', 'icon' => 'fa-circle'];
                                @endphp
                                <span class="inline-flex items-center gap-2 px-3 py-1 {{ $data['color'] }} rounded-lg text-xs font-semibold">
                                    <i class="fa-solid {{ $data['icon'] }}"></i>
                                    {{ ucfirst($activity->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                @if($activity->model)
                                    <span class="inline-block bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-300">
                                        {{ $activity->model }}
                                        @if($activity->model_id)
                                            <span class="text-gray-500 dark:text-gray-400">#{{ $activity->model_id }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300 max-w-md truncate">
                                @if($activity->description)
                                    <span title="{{ $activity->description }}">{{ $activity->description }}</span>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded text-xs font-mono">
                                    {{ $activity->ip_address ?? '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="fa-solid fa-inbox text-3xl opacity-50"></i>
                                    <p class="font-semibold">Aucune activité trouvée</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $activities->links() }}
    </div>

</div>

