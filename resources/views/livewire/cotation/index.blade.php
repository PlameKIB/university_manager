<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-clipboard-list text-indigo-600"></i>
            Mes cours
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            @if($activeYear)
                Année académique en cours : <span class="font-medium">{{ $activeYear->name }}</span>
            @else
                Aucune année académique active n'est définie
            @endif
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($assignments as $assignment)
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-5 flex flex-col justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">
                        {{ $assignment->course->intitule }}
                    </h3>
                    <p class="text-xs text-gray-400 mb-2">{{ $assignment->course->code }}</p>

                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fa-solid fa-layer-group text-indigo-500 mr-1"></i>
                        {{ $assignment->promotion->name }}
                    </p>

                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <i class="fa-solid fa-graduation-cap text-indigo-500 mr-1"></i>
                        {{ $assignment->credit }} crédit(s)
                    </p>

                    <div class="mt-3">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>Cotation</span>
                            <span>{{ $assignment->graded_count }} / {{ $assignment->students_count }} étudiant(s)</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            @php
                                $percent = $assignment->students_count > 0
                                    ? round(($assignment->graded_count / $assignment->students_count) * 100)
                                    : 0;
                            @endphp
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('cotation.grade', $assignment->id) }}"
                    class="mt-4 inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    <i class="fa-solid fa-pen"></i>
                    Coter les étudiants
                </a>
            </div>
        @empty
            <div class="col-span-full bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                Aucun cours ne vous est attribué pour l'année académique en cours.
            </div>
        @endforelse
    </div>

</div>