<div class="space-y-6">

    <div>
        <a href="{{ route('cotation.index') }}" class="text-sm text-indigo-600 hover:underline">
            <i class="fa-solid fa-arrow-left mr-1"></i> Retour à mes cours
        </a>

        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2 mt-2">
            <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
            {{ $courseAssignment->course->intitule }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $courseAssignment->promotion->name }} — {{ $courseAssignment->academicYear->name }}
            — Barèmes : TP/{{ $courseAssignment->bareme_tp }},
            Interro/{{ $courseAssignment->bareme_interro }},
            Examen/{{ $courseAssignment->bareme_examen }}
            (total /{{ $courseAssignment->bareme_total }})
        </p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Matricule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Étudiant</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">TP /{{ $courseAssignment->bareme_tp }}</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interro /{{ $courseAssignment->bareme_interro }}</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Examen /{{ $courseAssignment->bareme_examen }}</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cote finale</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($students as $enrollment)
                    @php $studentId = $enrollment->user_id; @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $enrollment->user->matricule }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800 dark:text-gray-100">{{ $enrollment->user->name }}</td>

                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.5" min="0" max="{{ $courseAssignment->bareme_tp }}"
                                wire:model="grades.{{ $studentId }}.tp"
                                class="w-20 text-center rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-1">
                            @error("grades.{$studentId}.tp") <div class="text-xs text-red-500">{{ $message }}</div> @enderror
                        </td>

                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.5" min="0" max="{{ $courseAssignment->bareme_interro }}"
                                wire:model="grades.{{ $studentId }}.interro"
                                class="w-20 text-center rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-1">
                            @error("grades.{$studentId}.interro") <div class="text-xs text-red-500">{{ $message }}</div> @enderror
                        </td>

                        <td class="px-6 py-4 text-center">
                            <input type="number" step="0.5" min="0" max="{{ $courseAssignment->bareme_examen }}"
                                wire:model="grades.{{ $studentId }}.examen"
                                class="w-20 text-center rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-1">
                            @error("grades.{$studentId}.examen") <div class="text-xs text-red-500">{{ $message }}</div> @enderror
                        </td>

                        <td class="px-6 py-4 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                            @php
                                $tp = $grades[$studentId]['tp'] ?? 0;
                                $interro = $grades[$studentId]['interro'] ?? 0;
                                $examen = $grades[$studentId]['examen'] ?? 0;
                            @endphp
                            {{ $tp + $interro + $examen }} / {{ $courseAssignment->bareme_total }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Aucun étudiant inscrit dans cette promotion pour cette année académique.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->isNotEmpty())
        <button wire:click="save"
            class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-600 rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
            <i class="fa-solid fa-floppy-disk"></i>
            Enregistrer les notes
        </button>
    @endif

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