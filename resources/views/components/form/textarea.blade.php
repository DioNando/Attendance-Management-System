@props(['name', 'value' => '', 'placeholder' => '', 'rows' => 3, 'live' => true])

<textarea @if ($live) wire:model.live.250ms="{{ $name }}" @else wire:model="{{ $name }}" @endif name="{{ $name }}" rows="{{ $rows }}"
    class="block w-full rounded-md bg-gray-300/10 dark:bg-white/5 px-3 py-1.5 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-blue-500 outline-gray-300 dark:outline-white/10 sm:text-sm/6"">{{ old($name, $value) }}</textarea>

<p class="mt-3 text-sm/6 text-gray-600 dark:text-gray-300">{{ $placeholder }}</p>
