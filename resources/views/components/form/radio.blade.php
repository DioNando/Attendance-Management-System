@props(['name', 'checked' => false, 'label' => '', 'direction' => null])

<div class="flex items-center text-sm text-gray-900 dark:text-gray-100 gap-x-3">
    @if ($direction === 'asc')
        <input wire:model.live.250ms="{{ $name }}" id="{{ $name }}" name="{{ $name }}"
            type="radio" {{ $checked ? 'checked' : '' }}
            class="relative size-4 appearance-none before:absolute before:content-[''] before:size-0 before:left-1/2 before:top-1/2 before:-translate-x-1/2 before:-translate-y-3/4 before:border-[6px] before:border-transparent before:border-b-gray-700 dark:before:border-b-gray-300 checked:before:border-b-blue-600 dark:checked:before:border-b-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:focus-visible:outline-blue-500 disabled:before:border-b-gray-400 cursor-pointer">
    @elseif($direction === 'desc')
        <input wire:model.live.250ms="{{ $name }}" id="{{ $name }}" name="{{ $name }}"
            type="radio" {{ $checked ? 'checked' : '' }}
            class="relative size-4 appearance-none before:absolute before:content-[''] before:size-0 before:left-1/2 before:top-1/2 before:-translate-x-1/2 before:-translate-y-1/4 before:border-[6px] before:border-transparent before:border-t-gray-700 dark:before:border-t-gray-300 checked:before:border-t-blue-600 dark:checked:before:border-t-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:focus-visible:outline-blue-500 disabled:before:border-t-gray-400 cursor-pointer">
    @else
        <input wire:model.live.250ms="{{ $name }}" id="{{ $name }}" name="{{ $name }}"
            type="radio" {{ $checked ? 'checked' : '' }}
            class="relative size-4 appearance-none rounded-full border border-gray-300 bg-gray-300/10 dark:bg-gray-800 dark:border-gray-600 before:absolute before:inset-1 before:rounded-full before:bg-white dark:before:bg-gray-700 not-checked:before:hidden checked:border-blue-600 checked:bg-blue-600 dark:checked:border-blue-500 dark:checked:bg-blue-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 dark:focus-visible:outline-blue-500 disabled:border-gray-300 disabled:bg-gray-100 dark:disabled:bg-gray-600 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden cursor-pointer">
    @endif
    <label for="{{ $name }}"
        class="block text-sm/6 font-medium text-gray-900 dark:text-gray-100 cursor-pointer checked:text-blue-600">{{ $label }}</label>
</div>
