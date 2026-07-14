<div class="space-y-6">

    <div>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-diagram-project text-indigo-600"></i>
            Attributions de cours
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Attribuer un cours à un enseignant, dans une promotion, pour une année académique
        </p>
    </div>

    {{-- FORMULAIRE --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 space-y-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- COURS --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cours</label>
                <select wire:model="course_id"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">Sélectionner un cours</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->code }} — {{ $course->intitule }}</option>
                    @endforeach
                </select>
                @error('course_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- PROMOTION --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Promotion</label>
                <select wire:model="promotion_id"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">Sélectionner une promotion</option>
                    @foreach($promotions as $promotion)
                        <option value="{{ $promotion->id }}">{{ $promotion->name }} ({{ $promotion->department->name }})</option>
                    @endforeach
                </select>
                @error('promotion_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- ENSEIGNANT --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Enseignant</label>
                <select wire:model="user_id"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">Sélectionner un enseignant</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @error('user_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- ANNEE ACADEMIQUE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Année académique</label>
                <select wire:model="academic_year_id"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                    <option value="">Sélectionner une année</option>
                    @foreach($academicYears as $year)
                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                    @endforeach
                </select>
                @error('academic_year_id') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            {{-- CREDIT --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Crédit</label>
                <input type="number" wire:model="credit" min="1" max="60"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @error('credit') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- BAREME TP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barème TP</label>
                <input type="number" step="0.5" wire:model="bareme_tp"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @error('bareme_tp') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- BAREME INTERRO --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barème Interro</label>
                <input type="number" step="0.5" wire:model="bareme_interro"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @error('bareme_interro') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- BAREME EXAMEN --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Barème Examen</label>
                <input type="number" step="0.5" wire:model="bareme_examen"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">
                @error('bareme_examen') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
            </div>

        </div>

        <div>
            @if($isEditing)
                <button wire:click="update"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Modifier
                </button>
            @else
                <button wire:click="save"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    <i class="fa-solid fa-plus"></i>
                    Attribuer
                </button>
            @endif
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cours</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Promotion</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Enseignant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Année</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Crédit</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Barèmes (TP/Interro/Examen)</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($assignments as $assignment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $assignment->course->code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $assignment->promotion->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $assignment->teacher->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $assignment->academicYear->name }}</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600 dark:text-gray-300">{{ $assignment->credit }}</td>
                        <td class="px-6 py-4 text-sm text-center text-gray-600 dark:text-gray-300">
                            {{ $assignment->bareme_tp }} / {{ $assignment->bareme_interro }} / {{ $assignment->bareme_examen }}
                            <span class="text-xs text-gray-400">(/{{ $assignment->bareme_total }})</span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="edit({{ $assignment->id }})"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button wire:click="delete({{ $assignment->id }})"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Aucune attribution trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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