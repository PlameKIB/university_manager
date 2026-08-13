<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-clock text-indigo-600"></i>
                Activités Récentes
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Les 10 dernières actions effectuées
            </p>
        </div>
        <a href="{{ route('admin.activity_logs') }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-semibold transition">
            Voir tout →
        </a>
    </div>

    <div class="space-y-3">
        @forelse($activities as $activity)
            <div class="flex items-start gap-4 pb-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0 last:pb-0 hover:bg-gray-50 dark:hover:bg-gray-700/40 px-3 py-2 rounded-lg transition">
                <!-- Icône d'action -->
                <div class="flex-shrink-0 pt-1">
                    @php
                        $actionIcons = [
                            'create' => ['icon' => 'fa-plus', 'color' => 'bg-green-100 dark:bg-green-900/30 text-green-600'],
                            'update' => ['icon' => 'fa-pen', 'color' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600'],
                            'delete' => ['icon' => 'fa-trash', 'color' => 'bg-red-100 dark:bg-red-900/30 text-red-600'],
                            'view' => ['icon' => 'fa-eye', 'color' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600'],
                            'login' => ['icon' => 'fa-arrow-right-to-bracket', 'color' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600'],
                            'logout' => ['icon' => 'fa-arrow-right-from-bracket', 'color' => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'],
                        ];
                        $action = $actionIcons[$activity->action] ?? ['icon' => 'fa-circle', 'color' => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400'];
                    @endphp
                    <div class="w-10 h-10 rounded-lg {{ $action['color'] }} flex items-center justify-center">
                        <i class="fa-solid {{ $action['icon'] }} text-sm"></i>
                    </div>
                </div>

                <!-- Contenu -->
                <div class="flex-grow min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-semibold text-gray-800 dark:text-white text-sm">
                            @if($activity->user)
                                {{ $activity->user->name }}
                            @else
                                <span class="text-gray-500 dark:text-gray-400">Système</span>
                            @endif
                        </span>
                        <span class="text-gray-600 dark:text-gray-300 text-sm">
                            @if($activity->description)
                                {{ $activity->description }}
                            @else
                                {{ ucfirst($activity->action) }}
                            @endif
                        </span>
                    </div>
                    @if($activity->model && $activity->model_id)
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span class="inline-block bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">
                                {{ $activity->model }} #{{ $activity->model_id }}
                            </span>
                        </div>
                    @endif
                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                        {{ $activity->created_at->diffForHumans() }}
                    </div>
                </div>

                <!-- Badge d'action -->
                <div class="flex-shrink-0 pt-0.5">
                    @php
                        $badgeColors = [
                            'create' => 'bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300',
                            'update' => 'bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300',
                            'delete' => 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300',
                            'view' => 'bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300',
                            'login' => 'bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300',
                            'logout' => 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300',
                        ];
                        $badgeClass = $badgeColors[$activity->action] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300';
                    @endphp
                    <span class="px-2 py-1 text-xs font-semibold {{ $badgeClass }} rounded-lg whitespace-nowrap">
                        {{ ucfirst($activity->action) }}
                    </span>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <i class="fa-solid fa-inbox text-3xl mb-2 opacity-50"></i>
                <p>Aucune activité récente</p>
            </div>
        @endforelse
    </div>
</div>
