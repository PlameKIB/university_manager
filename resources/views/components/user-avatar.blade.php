<div class="flex items-center gap-3">
    @if($photoUrl)
        <img src="{{ $photoUrl }}" alt="{{ $displayName }}"
             class="{{ $sizeClasses }} rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-800">
    @else
        <div class="{{ $sizeClasses }} rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center border-2 border-indigo-200 dark:border-indigo-800">
            <span class="font-bold text-indigo-600 dark:text-indigo-400">
                {{ $initials }}
            </span>
        </div>
    @endif

    @if($showName)
        <div>
            <p class="font-semibold text-gray-800 dark:text-white text-sm">
                {{ $displayName }}
            </p>
        </div>
    @endif
</div>
