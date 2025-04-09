<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Gestion des utilisateurs" />
    </x-slot>
    <div>
        <div class="my-3 flex items-start justify-end flex-wrap gap-3 sm:mt-0">
            <livewire:table.searchbar />
            <livewire:table.select-user-role />
        </div>
        <livewire:pages.user.table />
    </div>
</x-app-layout>
