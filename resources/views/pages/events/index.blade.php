<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Gestion des événements" />
    </x-slot>

    {{-- <div class="container mx-auto"> --}}
    <div>
        <div class="my-3 flex flex-wrap gap-3 sm:mt-0">
            @livewire('table.searchbar')
            <x-button.primary href="{{ route('admin.events.create') }}" responsive icon="heroicon-o-plus">
                {{ __('Ajouter un evenement') }}
            </x-button.primary>
        </div>
        <livewire:pages.events.table />
    </div>
</x-app-layout>
