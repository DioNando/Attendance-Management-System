@props([
    'name' => 'profile_photo',
    'value' => '',
    'placeholder' => 'Choisir une photo',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'accept' => 'image/jpeg,image/png,image/jpg',
    'showPreview' => true,
    'maxSize' => '5MB',
])

@php
    $isInvalid = $errors->has($name);

    $buttonClasses =
        'inline-flex w-fit items-center justify-center gap-2 rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2' .
        ($disabled ? ' opacity-50 cursor-not-allowed' : ' cursor-pointer');
        // . ($isInvalid ? ' border-red-300 ring-1 ring-red-500' : '');

    $previewClasses = 'mt-4 flex items-center';

    $imagePreviewClasses =
        'h-16 w-16 rounded-full object-cover border-2' .
        ($isInvalid ? ' border-red-300 dark:border-red-700' : ' border-gray-300 dark:border-gray-700');

    $fileNameClasses =
        'ml-3 text-sm font-medium ' .
        ($isInvalid ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-gray-300');
@endphp

<div class="{{ $class }}">
    <div class="flex flex-col space-y-2">
        <label for="{{ $name }}" class="{{ $buttonClasses }}">
            {{-- <x-heroicon-o-photo class="size-5" /> --}}
            <span>{{ $placeholder }}</span>
            <input wire:model.live="{{ $name }}" type="file" name="{{ $name }}" id="{{ $name }}"
                class="sr-only" @if ($required) required @endif
                @if ($disabled) disabled @endif
                @if ($accept) accept="{{ $accept }}" @endif>
        </label>

        <p class="text-xs text-gray-500 dark:text-gray-400">
            Formats acceptés: JPG, PNG. Maximum: {{ $maxSize }}
        </p>
    </div>
</div>
