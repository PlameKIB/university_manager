<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">

                <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                    <i class="fa-solid fa-users text-indigo-600"></i>
                </div>

                Étudiants

            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Gestion complète des étudiants enregistrés
            </p>
        </div>

        <a href="{{ route('student.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-700
                  text-white rounded-xl font-semibold text-sm transition shadow-sm">

            <i class="fa-solid fa-user-plus"></i>

            Nouvel étudiant

        </a>

    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- TOTAL --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Total étudiants
                    </p>

                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
                        {{ $totalStudents }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-users text-indigo-600 text-lg"></i>
                </div>

            </div>

        </div>

        {{-- MALE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Masculins
                    </p>

                    <h3 class="text-2xl font-bold text-blue-600 mt-1">
                        {{ $maleStudents }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-mars text-blue-600 text-lg"></i>
                </div>

            </div>

        </div>

        {{-- FEMALE --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Féminins
                    </p>

                    <h3 class="text-2xl font-bold text-pink-600 mt-1">
                        {{ $totalStudents - $maleStudents }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-venus text-pink-600 text-lg"></i>
                </div>

            </div>

        </div>

    </div>

    {{-- TABLE CARD --}}
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

        {{-- TOP BAR --}}
        <div
            class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex flex-col lg:flex-row lg:items-center gap-4 lg:justify-between">

            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                    Liste des étudiants
                </h3>

                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Recherchez et gérez les étudiants
                </p>
            </div>

            {{-- SEARCH --}}
            <div class="relative w-full lg:w-80">

                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-search text-gray-400 text-sm"></i>
                </div>

                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher un étudiant..."
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white text-sm
                           focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700">

                    <tr>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Étudiant
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Matricule
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Téléphone
                        </th>

                        <th
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Genre
                        </th>

                        <th
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                    @forelse($students as $student)

                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20 transition">

                            {{-- STUDENT --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-4">

                                    @if($student->photo)
                                        <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->name }}"
                                             class="w-11 h-11 rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-800 flex-shrink-0">
                                    @else
                                        <div class="w-11 h-11 rounded-full bg-indigo-100 dark:bg-indigo-900/30
                                                        flex items-center justify-center flex-shrink-0">

                                            <span class="text-indigo-600 font-bold text-sm">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </span>

                                        </div>
                                    @endif

                                    <div>

                                        <div class="font-semibold text-gray-800 dark:text-white text-sm">
                                            {{ $student->name }}
                                        </div>

                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $student->email ?? 'Aucun email' }}
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

                                    {{ $student->matricule }}

                                </span>

                            </td>

                            {{-- TELEPHONE --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ $student->telephone ?? '--' }}
                                </span>

                            </td>

                            {{-- GENRE --}}
                            <td class="px-6 py-4">

                                @if($student->genre == 'M')

                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                                         bg-blue-100 dark:bg-blue-900/30
                                                         text-blue-600 text-xs font-semibold">

                                        <i class="fa-solid fa-mars"></i>

                                        Masculin

                                    </span>

                                @elseif($student->genre == 'F')

                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg
                                                         bg-pink-100 dark:bg-pink-900/30
                                                         text-pink-600 text-xs font-semibold">

                                        <i class="fa-solid fa-venus"></i>

                                        Féminin

                                    </span>

                                @else

                                    <span class="text-xs text-gray-400">
                                        Non défini
                                    </span>

                                @endif

                            </td>

                            {{-- ACTIONS --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- SHOW --}}
                                    <a href="" class="w-9 h-9 rounded-lg bg-blue-50 hover:bg-blue-100
                                                  dark:bg-blue-900/20 dark:hover:bg-blue-900/40
                                                  flex items-center justify-center text-blue-600 transition">

                                        <i class="fa-solid fa-eye text-sm"></i>

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="{{ route('student.edit', $student->id) }}" class="w-9 h-9 rounded-lg bg-amber-50 hover:bg-amber-100
                                                  dark:bg-amber-900/20 dark:hover:bg-amber-900/40
                                                  flex items-center justify-center text-amber-600 transition">

                                        <i class="fa-solid fa-pen text-sm"></i>

                                    </a>

                                    {{-- DELETE --}}
                                    <button wire:click="delete({{ $student->id }})"
                                        wire:confirm="Voulez-vous vraiment supprimer cet étudiant ?" class="w-9 h-9 rounded-lg bg-red-50 hover:bg-red-100
                                                   dark:bg-red-900/20 dark:hover:bg-red-900/40
                                                   flex items-center justify-center text-red-600 transition">

                                        <i class="fa-solid fa-trash text-sm"></i>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="w-20 h-20 rounded-2xl bg-gray-100 dark:bg-gray-700
                                                    flex items-center justify-center mb-4">

                                        <i class="fa-solid fa-users-slash text-3xl text-gray-400"></i>

                                    </div>

                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-white">
                                        Aucun étudiant trouvé
                                    </h3>

                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Commencez par créer un nouvel étudiant.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        @if($students->hasPages())

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">

                {{ $students->links() }}

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