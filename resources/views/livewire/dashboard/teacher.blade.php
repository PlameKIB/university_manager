<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                <i class="fa-solid fa-chalkboard-user text-amber-600"></i>
            </div>
            Mon tableau de bord
        </h2>

        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Aperçu de vos cours et de vos cotations
            @if($activeYear)
                &middot; Année académique <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $activeYear->name }}</span>
            @endif
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Mes cours</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalCourses }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-book text-indigo-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Étudiants encadrés</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalStudents }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-100 dark:bg-sky-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-users text-sky-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cours à coter</p>
                    <h3 class="text-2xl font-bold {{ $pendingGrading > 0 ? 'text-amber-600' : 'text-emerald-600' }} mt-1">
                        {{ $pendingGrading }}
                    </h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-pen-to-square text-amber-600 text-lg"></i>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cotations complétées</p>
                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $completionRate }}%</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <i class="fa-solid fa-chart-pie text-emerald-600 text-lg"></i>
                </div>
            </div>
            <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden mt-4">
                <div class="h-full rounded-full bg-emerald-500" style="width: {{ $completionRate }}%"></div>
            </div>
        </div>

    </div>

    {{-- MY COURSES --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden shadow-sm">

        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">Mes cours &amp; cotations</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Cliquez sur un cours pour saisir ou modifier les notes de vos étudiants
            </p>
        </div>

        <div class="divide-y divide-gray-100 dark:divide-gray-700">

            @forelse($assignments as $assignment)

                @php
                    $progress = $assignment->students_count > 0
                        ? round(($assignment->graded_count / $assignment->students_count) * 100)
                        : 0;
                    $isComplete = $assignment->students_count > 0 && $assignment->graded_count >= $assignment->students_count;
                @endphp

                <a href="{{ route('cotation.grade', $assignment) }}" wire:navigate
                    class="flex flex-col sm:flex-row sm:items-center gap-4 px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">

                    <div class="w-11 h-11 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-book-open text-indigo-600"></i>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                            {{ $assignment->course->intitule ?? '--' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ $assignment->promotion->name ?? '--' }}
                            &middot; {{ $assignment->students_count }} étudiant(s)
                        </p>
                    </div>

                    <div class="flex items-center gap-3 sm:w-48 w-full">
                        <div class="w-full h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">
                            <div class="h-full rounded-full {{ $isComplete ? 'bg-emerald-500' : 'bg-amber-500' }}"
                                style="width: {{ $progress }}%">
                            </div>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 w-10 text-right">
                            {{ $progress }}%
                        </span>
                    </div>

                    <span class="text-[11px] font-semibold px-2.5 py-1 rounded-lg flex-shrink-0
                                 {{ $isComplete ? 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30' : 'bg-amber-100 text-amber-600 dark:bg-amber-900/30' }}">
                        {{ $isComplete ? 'Terminé' : 'À faire' }}
                    </span>

                </a>

            @empty

                <div class="px-6 py-12 text-center">
                    <i class="fa-solid fa-book text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                    <p class="text-sm text-gray-400">Aucun cours ne vous est assigné pour l'année active</p>
                </div>

            @endforelse

        </div>

    </div>

</div>
