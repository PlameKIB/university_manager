<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="fa-solid fa-book text-indigo-600"></i>
            Cours
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Catalogue des cours enseignés
        </p>
    </div>

    {{-- FORMULAIRE --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- CODE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Code du cours
                </label>

                <input type="text" wire:model="code" placeholder="Ex: INFO101"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">

                @error('code')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            {{-- INTITULE --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Intitulé du cours
                </label>

                <input type="text" wire:model="intitule" placeholder="Ex: Algorithmique et structures de données"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 p-2">

                @error('intitule')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="mt-4">
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
                    Ajouter
                </button>
            @endif
        </div>

    </div>

    {{-- TABLE --}}
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Intitulé</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($courses as $course)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300">{{ $course->id }}</td>
                        <td class="px-6 py-4 text-sm uppercase font-medium text-gray-800 dark:text-gray-100">{{ $course->code }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $course->intitule }}</td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button wire:click="edit({{ $course->id }})"
                                class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium cursor-pointer">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button wire:click="delete({{ $course->id }})"
                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium cursor-pointer">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            Aucun cours trouvé
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