@props([
    'name',
    'label',
    'items' => [],
    'placeholder' => '',
    'addText' => 'Ajouter un élément',
    'addMethod' => '',
    'removeMethod' => '',
    'inputClass' => 'flex-1',
])

<div>
    <label for="{{ $name }}"
        class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">{{ $label }}</label>
    <div class="mt-2">
        <div>
            @foreach ($items ?? [] as $index => $item)
                <div class="flex items-center gap-x-3 mb-3">
                    <x-form.input name="{{ $name }}.{{ $index }}" placeholder="{{ $placeholder }}"
                        class="{{ $inputClass }}" />
                    <button type="button" wire:click="{{ $removeMethod }}({{ $index }})"
                        class="flex shrink-0 items-center rounded-md text-red-600 hover:text-red-700 hover:bg-gray-100 dark:hover:bg-gray-800 focus-visible:outline-red-600 dark:text-red-600 dark:hover:text-red-700 dark:focus-visible:outline-red-700 px-3 py-2 text-sm font-semibold focus-visible:outline-2 focus-visible:outline-offset-2
           ">
                        <x-heroicon-o-x-mark class="size-5" />
                    </button>
                </div>
            @endforeach
            {{-- <button type="button" wire:click="{{ $addMethod }}"
                class="inline-flex items-center gap-x-2 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 dark:bg-white/5 dark:text-white dark:ring-white/10 hover:bg-gray-50 dark:hover:bg-white/10">
                <x-heroicon-o-plus class="h-5 w-5" />
                {{ $addText }}
            </button> --}}
            <div class="inline-block" wire:click="{{ $addMethod }}">
                <x-button.primary icon="heroicon-o-plus" responsive>
                    {{ $addText }}
                </x-button.primary>
            </div>
        </div>
    </div>
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
