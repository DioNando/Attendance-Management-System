@props(['name', 'options' => [], 'size' => 'md', 'class' => '', 'live' => true])

@php
    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3 py-1.5 text-base',
        'lg' => 'px-4 py-2 text-lg',
    ];

    $inputClasses =
        'col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-100 dark:bg-white/5 py-1.5 pr-8 pl-3 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 *:bg-gray-200 dark:*:bg-gray-800 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-500 sm:text-sm/6' .
        ' ' .
        ($errors->has($name) ? 'outline-red-500 dark:outline-red-400' : 'outline-gray-300 dark:outline-white/10') .
        ' ' .
        $sizes[$size] .
        ' ' .
        $class;
@endphp

<div class="mt-2 grid grid-cols-1">
    <select
        @if ($live) wire:model.live.250ms="{{ $name }}" @else wire:model="{{ $name }}" @endif
        id="{{ $name }}" name="{{ $name }}" class="{{ $inputClasses }}">
        @if (!isset($attributes['required']))
            <option value="">Sélectionner une option</option>
        @endif
        @forelse ($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @empty
            <option value="">Aucune option disponible</option>
        @endforelse
    </select>
    <x-heroicon-o-chevron-down
        class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-400 sm:size-4" />
</div>
