@props(['name', 'label' => '', 'required' => false])

<label for="{{ $name }}" class="block text-sm font-medium text-gray-900 dark:text-gray-100">
    {{ $label }} <span class="@error($name) text-red-600 dark:text-red-400 @enderror">
        @if ($required)
            {{ ' *' }}
        @endif
    </span>
</label>
