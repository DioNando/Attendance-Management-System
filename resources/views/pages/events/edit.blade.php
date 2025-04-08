<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Modification d'un événement" />
    </x-slot>
    <livewire:pages.events.edit :event="$event ?? null" />
</x-app-layout>
