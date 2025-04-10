@props(['title', 'value', 'icon', 'iconColor' => 'blue'])

@php
    $bgColors = [
        'blue' => 'bg-blue-100 dark:bg-blue-900',
        'indigo' => 'bg-indigo-100 dark:bg-indigo-900',
        'green' => 'bg-green-100 dark:bg-green-900',
        'yellow' => 'bg-yellow-100 dark:bg-yellow-900',
        'red' => 'bg-red-100 dark:bg-red-900',
        'gray' => 'bg-gray-100 dark:bg-gray-900',
    ];

    $textColors = [
        'blue' => 'text-blue-600 dark:text-blue-400',
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'green' => 'text-green-600 dark:text-green-400',
        'yellow' => 'text-yellow-600 dark:text-yellow-400',
        'red' => 'text-red-600 dark:text-red-400',
        'gray' => 'text-gray-600 dark:text-gray-400',
    ];

    $bgColor = $bgColors[$iconColor] ?? $bgColors['blue'];
    $textColor = $textColors[$iconColor] ?? $textColors['blue'];
@endphp

<div class="rounded-lg bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $title }}</p>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $value }}</p>
        </div>
        <div class="rounded-full {{ $bgColor }} p-3">
            <x-dynamic-component :component="$icon" class="h-6 w-6 {{ $textColor }}" />
        </div>
    </div>
</div>
