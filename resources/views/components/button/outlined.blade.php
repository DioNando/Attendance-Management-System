@props([
    'type' => 'button',
    'color' => 'blue',
    'size' => 'md',
    'class' => '',
    'icon' => null,
    'responsive' => false,
])

@php
    $colors = [
        'red' => [
            'default' => 'text-red-600 hover:bg-red-50 focus-visible:outline-red-600',
            'dark' => 'dark:text-red-500 dark:hover:bg-red-900/30 dark:focus-visible:outline-red-500',
        ],
        'blue' => [
            'default' => 'text-blue-600 hover:bg-blue-50 focus-visible:outline-blue-600',
            'dark' => 'dark:text-blue-500 dark:hover:bg-blue-900/30 dark:focus-visible:outline-blue-500',
        ],
        'green' => [
            'default' => 'text-green-600 hover:bg-green-50 focus-visible:outline-green-600',
            'dark' => 'dark:text-green-500 dark:hover:bg-green-900/30 dark:focus-visible:outline-green-500',
        ],
        'orange' => [
            'default' => 'text-orange-600 hover:bg-orange-50 focus-visible:outline-orange-600',
            'dark' => 'dark:text-orange-500 dark:hover:bg-orange-900/30 dark:focus-visible:outline-orange-500',
        ],
        'gray' => [
            'default' => 'text-gray-700 hover:bg-gray-50 outline-gray-300 focus-visible:outline-gray-500',
            'dark' =>
                'dark:text-gray-400 dark:hover:bg-gray-900/30 dark:outline-gray-600 dark:focus-visible:outline-gray-400',
        ],
    ];

    $padding = match ($size) {
        'sm' => 'px-2 py-1 text-xs',
        'lg' => 'px-4 py-3 text-lg',
        default => 'px-3 py-2 text-sm',
    };
@endphp

<button type="{{ $type }}"
    class="flex shrink-0 items-center gap-x-1.5 rounded-md {{ $colors[$color]['default'] }} {{ $colors[$color]['dark'] }} {{ $padding }}
           font-semibold outline-1 -outline-offset-1 shadow-xs focus-visible:outline-0 focus-visible:outline-offset-2
            {{ $class }}">
    @if ($icon)
        <x-dynamic-component :component="$icon" class="size-5 flex-shrink-0" />
    @endif
    <span :class="@if ($responsive) 'hidden md:inline' @else 'inline' @endif">{{ $slot }}</span>

</button>
