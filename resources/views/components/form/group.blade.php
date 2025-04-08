@props(['name', 'label' => '', 'required' => false])

<div>
    {{-- <label for="{{ $name }}" class="block text-sm font-medium text-gray-900 dark:text-gray-100">
        {{ $label }} <span class="@error($name) text-red-600 dark:text-red-400 @enderror">
            @if ($required)
                {{ ' *' }}
            @endif
        </span>
    </label> --}}
    <x-form.label :name="$name" :label="$label" :required="$required" />
    <div class="mt-2">
        {{ $slot }}
    </div>
    {{-- @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror --}}
    <x-form.error :name="$name" />
</div>
