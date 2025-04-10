@props(['type' => 'success', 'message' => null])

@php
    $types = [
        'success' => [
            'bg' => 'bg-green-100 border-green-400',
            'text' => 'text-green-700',
            'icon' => 'heroicon-o-check-circle',
        ],
        'error' => [
            'bg' => 'bg-red-100 border-red-400',
            'text' => 'text-red-700',
            'icon' => 'heroicon-o-x-circle',
        ],
        'warning' => [
            'bg' => 'bg-yellow-100 border-yellow-400',
            'text' => 'text-yellow-700',
            'icon' => 'heroicon-o-exclamation-triangle',
        ],
        'info' => [
            'bg' => 'bg-blue-100 border-blue-400',
            'text' => 'text-blue-700',
            'icon' => 'heroicon-o-information-circle',
        ],
    ];

    $config = $types[$type] ?? $types['success'];
@endphp

@if ($message || session()->has($type))
    <div
        {{ $attributes->merge(['class' => "text-sm mt-4 p-3 {$config['bg']} border {$config['text']} rounded-md flex items-start"]) }}>
        <div class="flex-shrink-0 mr-2">
            <x-dynamic-component :component="$config['icon']" class="w-5 h-5" />
        </div>
        <div>
            {{ $message ?? session($type) }}
        </div>
    </div>
@endif
