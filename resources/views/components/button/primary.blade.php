@props([
    'href' => '#',
    'type' => 'link',
    'color' => 'blue',
    'size' => 'md',
    'class' => '',
    'icon' => null,
    'responsive' => false,
    'disabled' => false,
    'wire:navigate' => true,
])

@php
    $colors = [
        'red' => [
            'default' => 'bg-red-600 hover:bg-red-700 focus-visible:outline-red-600 text-white',
            'dark' => 'dark:bg-red-500 dark:hover:bg-red-400 dark:focus-visible:outline-red-500 dark:text-gray-50',
        ],
        'blue' => [
            'default' => 'bg-blue-600 hover:bg-blue-700 focus-visible:outline-blue-600 text-white',
            'dark' => 'dark:bg-blue-500 dark:hover:bg-blue-400 dark:focus-visible:outline-blue-500 dark:text-gray-50',
        ],
        'green' => [
            'default' => 'bg-green-600 hover:bg-green-700 focus-visible:outline-green-600 text-white',
            'dark' =>
                'dark:bg-green-500 dark:hover:bg-green-400 dark:focus-visible:outline-green-500 dark:text-gray-50',
        ],
        'orange' => [
            'default' => 'bg-orange-600 hover:bg-orange-700 focus-visible:outline-orange-600 text-white',
            'dark' =>
                'dark:bg-orange-500 dark:hover:bg-orange-400 dark:focus-visible:outline-orange-500 dark:text-gray-50',
        ],
        'gray' => [
            'default' => 'bg-gray-600 hover:bg-gray-700 focus-visible:outline-gray-600 text-white',
            'dark' => 'dark:bg-gray-500 dark:hover:bg-gray-400 dark:focus-visible:outline-gray-500 dark:text-gray-50',
        ],
    ];

    $padding = match ($size) {
        'sm' => 'px-2 py-1 text-xs',
        'lg' => 'px-4 py-3 text-lg',
        default => 'px-3 py-2 text-sm',
    };

    $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';
@endphp

@if ($type === 'link')
    <a href="{{ $disabled ? '#' : $href }}"
        {{ $disabled ? '' : ($attributes->get('wire:navigate') !== false ? 'wire:navigate' : '') }}
        class="cursor-pointer flex shrink-0 items-center gap-x-1.5 rounded-md {{ $colors[$color]['default'] }} {{ $colors[$color]['dark'] }} {{ $padding }}
               font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2
               {{ $disabledClasses }} {{ $class }}">
        @if ($icon)
            <x-dynamic-component :component="$icon" class="size-5 flex-shrink-0" />
        @endif
        <span @class([$responsive ? 'hidden md:inline' : 'inline'])>{{ $slot }}</span>
    </a>
@else
    <button {{ $attributes }} type="{{ $type }}" {{ $disabled ? 'disabled' : '' }}
        class="cursor-pointer flex shrink-0 items-center gap-x-1.5 rounded-md {{ $colors[$color]['default'] }} {{ $colors[$color]['dark'] }} {{ $padding }}
               font-semibold shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2
               {{ $disabledClasses }} {{ $class }}">
        @if ($icon)
            <x-dynamic-component :component="$icon" class="size-5 flex-shrink-0" />
        @endif
        <span @class([$responsive ? 'hidden md:inline' : 'inline'])>{{ $slot }}</span>
    </button>
@endif
