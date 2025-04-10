@props([
    'name',
    'value' => '',
    'placeholder' => 'Télécharger un fichier',
    'required' => false,
    'disabled' => false,
    'class' => '',
    'accept' => '',
    'multiple' => false,
    'maxSize' => '10MB',
    'allowedTypes' => 'PDF, WORD',
    'files' => [],
    'file',
])

@php
    $isInvalid = $errors->has($name);

    $mainClasses =
        'flex items-center gap-4 rounded-lg border border-dashed ' .
        ($isInvalid ? 'border-red-500 dark:border-red-400' : 'border-gray-900/25 dark:border-gray-600') .
        ' px-4 py-4 ' .
        $class;
@endphp

<label class="cursor-pointer" for="{{ $name }}">
    <div class="{{ $mainClasses }}">
        <x-heroicon-o-paper-clip class="size-12 text-gray-300 dark:text-gray-500" />
        <div>
            <div class="flex text-sm/6 text-gray-600 dark:text-gray-400">
                <label for="{{ $name }}"
                    class="relative cursor-pointer rounded-md font-semibold text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                    <span>{{ $placeholder }}</span>
                    <input wire:model.live="{{ $name }}" id="{{ $name }}" name="{{ $name }}"
                        type="file" class="sr-only" @if ($required) required @endif
                        @if ($disabled) disabled @endif
                        @if ($multiple) multiple @endif
                        @if ($accept) accept="{{ $accept }}" @endif>
                </label>
            </div>

            <p class="text-xs/5 text-gray-600 dark:text-gray-400">{{ $allowedTypes }} jusqu'à {{ $maxSize }}</p>

            <div
                class="mt-2 flex flex-col flex-wrap gap-2 text-sm font-medium
        {{ $isInvalid ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }} ">
                {{-- @if ($files)
                @foreach ($files as $file)
                    <span>
                        {{ $file->getClientOriginalName() }}
                    </span>
                @endforeach
            @else
                <span>
                    Aucun fichier sélectionné
                </span>
            @endif --}}
                <span>
                    {{ $file }}
                </span>
            </div>
        </div>
    </div>
</label>
