@props(['title', 'description' => '', 'divider' => false, 'defaultOpen' => true, 'class' => ''])

<div x-data="{ open: {{ $defaultOpen ? 'true' : 'false' }} }"
    class="overflow-hidden rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 {{ $class }}">
    <div class="px-5 sm:p-6 py-6 sm:py-7 bg-blue-200 dark:bg-gray-800 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <button @click="open = !open"
                class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <x-heroicon-o-chevron-down x-show="open" x-cloak class="size-5" />
                <x-heroicon-o-chevron-right x-show="!open" x-cloak class="size-5" />
            </button>
            <div>
                <h3 class="text-lg font-semibold text-blue-700 dark:text-white">{{ $title }}</h3>
                @if ($description)
                    <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-300">{{ $description }}</p>
                @endif
            </div>
        </div>
    </div>
    <div x-show="open" x-cloak
        class="px-5 sm:p-6 py-6 sm:py-7 {{ $divider ? 'divide-y divide-gray-200 dark:divide-gray-700' : '' }}">
        {{ $slot }}
    </div>
</div>
