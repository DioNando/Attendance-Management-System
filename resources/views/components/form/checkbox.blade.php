@props(['name', 'checked' => false, 'label' => '', 'live' => false])

<div class="flex items-center text-sm text-gray-900 dark:text-gray-100 gap-x-3">
    <input
        @if ($live) wire:model.live.250ms="{{ $name }}" @else wire:model="{{ $name }}" @endif
        id="{{ $name }}" name="{{ $name }}" type="checkbox" {{ $checked ? 'checked' : '' }}
        class="relative flex-shrink-0 size-4 appearance-none rounded border border-gray-300 bg-gray-300/10 dark:bg-gray-800 dark:border-gray-600 before:absolute before:inset-1 before:rounded before:bg-white dark:before:bg-gray-700 not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 dark:checked:border-blue-500 dark:checked:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:focus-visible:outline-blue-500 disabled:border-gray-300 disabled:bg-gray-100 dark:disabled:bg-gray-600 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden cursor-pointer">
    @if ($label)
        <label for="{{ $name }}"
            class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100 cursor-pointer checked:text-blue-600">{{ $label }}</label>
    @endif
</div>
