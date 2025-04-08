@props(['icon' => '', 'label'])

<div class="flex items-center gap-4">
    <a class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300 border-r-2 pr-4 border-gray-400 dark:border-gray-500"
        {{-- href="{{ url()->previous() }}" --}}
       href="javascript:history.back()">
        <x-heroicon-o-chevron-left class="size-5 shrink-0" aria-hidden="true" />
        <span class="sr-only">Retour</span> Retour
    </a>
    {{-- <span class="text-gray-500 dark:text-gray-600">|</span> --}}
    <h3 class="flex items-center gap-2 text-lg font-bold text-blue-600 dark:text-blue-400">
        @if ($icon)
            <x-dynamic-component :component="'heroicon-o-' . $icon" class="size-6 shrink-0" />
        @endif
        {{ $label }}
    </h3>
</div>
