<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Modification d'un invité" />
    </x-slot>
    <livewire:pages.guests.edit :guest="$guest ?? null"  />
</x-app-layout>
