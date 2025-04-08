@props([
    'type' => 'text',
    'name',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'autocomplete' => 'on',
    'size' => 'md',
    'class' => '',
    'live' => false,
])

@php
    $isInvalid = $errors->has($name);

    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-sm',
        'md' => 'px-3 py-1.5 text-base',
        'lg' => 'px-4 py-2 text-lg',
    ];

    $inputClasses =
        'block w-full rounded-md bg-gray-300/10 dark:bg-white/5 px-3 py-1.5 text-base text-gray-900 dark:text-white border-none outline outline-1 -outline-offset-1 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-1 focus:outline-blue-500 sm:text-sm/6' .
        ' ' .
        ($isInvalid ? 'outline-red-500 dark:outline-red-400' : 'outline-gray-300 dark:outline-white/10') . ' ' .
        ($disabled ? 'opacity-40 cursor-not-allowed' : '') .
        ' ' .
        $sizes[$size] .
        ' ' .
        $class;
@endphp

<input
    @if ($live) wire:model.live.250ms="{{ $name }}" @else wire:model="{{ $name }}" @endif
    type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder }}"
    @required($required) autocomplete="{{ $autocomplete }}" @disabled($disabled) class="{{ $inputClasses }}">
