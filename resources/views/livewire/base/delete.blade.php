<!-- resources/views/livewire/delete-modal.blade.php -->
<div x-data="{ open: false }">
    <!-- Bouton intégré -->
    @if (!isset($entity))
        <div @click="open = true"
            class="text-gray-600 dark:text-gray-200 hover:text-red-500 dark:hover:text-red-400 gap-1 flex items-center cursor-pointer">
            {{ $buttonLabel }}
        </div>
    @else
        <div @click="open = true">
            <x-button.outlined color="gray" responsive icon="heroicon-o-trash">
                Supprimer
            </x-button.outlined>
        </div>
    @endif

    <!-- Modal -->
    {{-- @if ($isOpen) --}}
    <div x-show="open" @keydown.escape.window="open = false" @click.away="open = false" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/75 transition-opacity"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div x-transition class="relative overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl sm:p-6 p-4">

            <!-- Header -->
            <div class="flex items-center gap-4">
                <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:size-10">
                    <x-heroicon-o-exclamation-triangle class="size-6 text-red-600" />
                </div>
                <h3 id="modal-title" class="text-base font-semibold text-gray-900 dark:text-white">
                    {{ $title }}
                </h3>
            </div>

            <!-- Body -->
            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                <p> {{ $body }}</p>
            </div>

            <!-- Actions -->
            <div class="mt-5 sm:mt-4 flex flex-row-reverse gap-3">
                <div wire:click="delete">
                    <x-button.primary color="red">{{ $confirmButtonText }}</x-button.primary>
                </div>
                <div @click="open = false">
                    <x-button.outlined type="button" color="gray">{{ $cancelButtonText }}</x-button.outlined>
                </div>
            </div>
        </div>
    </div>
    {{-- @endif --}}
</div>
