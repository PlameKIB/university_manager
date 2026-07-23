<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-user-shield text-indigo-600"></i>
                </div>

                Gestion des utilisateurs

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Octroyez ou retirez des rôles, gérez les comptes de la plateforme
            </p>
        </div>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total utilisateurs</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalUsers }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <i class="fa-solid fa-users text-gray-600 dark:text-gray-300 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Administrateurs</p>
                    <h3 class="text-2xl font-bold text-red-600 mt-1">{{ $totalAdmins }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-user-shield text-red-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enseignants</p>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ $totalTeachers }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-chalkboard-user text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Étudiants</p>
                    <h3 class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalStudents }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-user-graduate text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- TOP BAR --}}
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row lg:items-center gap-4 lg:justify-between">

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Liste des utilisateurs</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Recherchez, filtrez par rôle et gérez les accès</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                {{-- ROLE FILTER --}}
                <select wire:model.live="roleFilter"
                    class="w-full sm:w-48 px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="enseignant">Enseignant</option>
                    <option value="student">Étudiant</option>
                </select>

                {{-- SEARCH --}}
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Nom, email, matricule..."
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                               bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                </div>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Utilisateur</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Matricule</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Rôles</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($users as $user)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            {{-- USER --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-11 h-11 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                                flex items-center justify-center flex-shrink-0">
                                        <span class="text-indigo-600 font-bold text-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-800 dark:text-white text-sm truncate">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="text-[10px] font-semibold text-indigo-500 ml-1">(vous)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 truncate">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- MATRICULE --}}
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                             bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200
                                             text-xs font-semibold">
                                    <i class="fa-solid fa-id-card"></i>
                                    {{ $user->matricule ?? '--' }}
                                </span>
                            </td>

                            {{-- ROLES --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($user->roles as $role)
                                        @php
                                            $roleStyles = [
                                                'admin' => 'bg-red-100 text-red-600 dark:bg-red-900/30',
                                                'enseignant' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/30',
                                                'student' => 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30',
                                            ];
                                            $roleLabels = [
                                                'admin' => 'Administrateur',
                                                'enseignant' => 'Enseignant',
                                                'student' => 'Étudiant',
                                            ];
                                        @endphp
                                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg
                                                     {{ $roleStyles[$role->name] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ $roleLabels[$role->name] ?? $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Aucun rôle</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">

                                    {{-- MANAGE ROLES --}}
                                    <button wire:click="openRoles({{ $user->id }})"
                                        class="w-9 h-9 rounded-lg bg-indigo-50 hover:bg-indigo-100
                                               dark:bg-indigo-900/20 dark:hover:bg-indigo-900/40
                                               flex items-center justify-center text-indigo-600 transition"
                                        title="Gérer les rôles">
                                        <i class="fa-solid fa-user-gear text-sm"></i>
                                    </button>

                                    {{-- DELETE --}}
                                    @if($user->id !== auth()->id())
                                        <button wire:click="delete({{ $user->id }})"
                                            wire:confirm="Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible."
                                            class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100
                                                   dark:bg-red-900/20 dark:hover:bg-red-900/40
                                                   flex items-center justify-center text-red-600 transition"
                                            title="Supprimer">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    @else
                                        <span class="w-9 h-9 rounded-lg bg-gray-50 dark:bg-gray-900
                                                     flex items-center justify-center text-gray-300 dark:text-gray-600"
                                            title="Vous ne pouvez pas supprimer votre propre compte">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </span>
                                    @endif

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 rounded-2xl bg-gray-100 dark:bg-gray-700
                                                flex items-center justify-center mb-4">
                                        <i class="fa-solid fa-users-slash text-3xl text-gray-400"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Aucun utilisateur trouvé</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Essayez une autre recherche ou un autre filtre.</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($users->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                {{ $users->links() }}
            </div>
        @endif

    </div>

    {{-- ROLE MANAGEMENT MODAL --}}
    <flux:modal wire:model="showRoleModal" name="manage-roles" class="max-w-md">

        <div class="space-y-6">

            <div>
                <flux:heading size="lg">Gérer les rôles</flux:heading>
                <flux:subheading>
                    {{ $selectedUserName }} &middot; {{ $selectedUserEmail }}
                </flux:subheading>
            </div>

            <div class="space-y-3">

                @foreach($availableRoles as $roleValue => $roleLabel)

                    @php
                        $roleIcons = [
                            'admin' => ['fa-user-shield', 'text-red-600', 'bg-red-100 dark:bg-red-900/30'],
                            'enseignant' => ['fa-chalkboard-user', 'text-amber-600', 'bg-amber-100 dark:bg-amber-900/30'],
                            'student' => ['fa-user-graduate', 'text-indigo-600', 'bg-indigo-100 dark:bg-indigo-900/30'],
                        ];
                        [$icon, $iconColor, $iconBg] = $roleIcons[$roleValue] ?? ['fa-user', 'text-gray-600', 'bg-gray-100'];
                    @endphp

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 dark:border-gray-700
                                  hover:bg-gray-50 dark:hover:bg-gray-700/40 cursor-pointer transition">

                        <input type="checkbox" wire:model="selectedRoles" value="{{ $roleValue }}"
                            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">

                        <div class="w-9 h-9 rounded-lg {{ $iconBg }} flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid {{ $icon }} {{ $iconColor }} text-sm"></i>
                        </div>

                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ $roleLabel }}</span>

                    </label>

                @endforeach

            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled" wire:click="closeRoleModal">Annuler</flux:button>
                </flux:modal.close>

                <flux:button variant="filled" class="!bg-indigo-600 !text-white hover:!bg-indigo-700" wire:click="saveRoles">
                    Enregistrer
                </flux:button>
            </div>

        </div>

    </flux:modal>

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
            timer: 3500,
            background: '#1f2937',
            color: '#fff'
        });
    });
</script>
@endscript
