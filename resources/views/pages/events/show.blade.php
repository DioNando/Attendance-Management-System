<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Détails d'un événement" />
    </x-slot>

    <!-- Event Information Card -->
    <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
        <div class="p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $event->name }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <span class="inline-flex items-center">
                            <x-heroicon-o-calendar class="w-4 h-4 mr-1" />
                            {{ $event->start_date->format('d/m/Y') }}
                            {{ $event->end_date ? '- ' . $event->end_date->format('d/m/Y') : '' }}
                        </span>
                    </p>
                </div>
                {{-- <div class="mt-3 sm:mt-0">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $event->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div> --}}
            </div>

            @if($event->description)
            <div class="mt-3 text-gray-700 dark:text-gray-300">
                <p>{{ $event->description }}</p>
            </div>
            @endif

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Lieu</h4>
                    <p class="text-gray-700 dark:text-gray-300">{{ $event->location ?? 'Non spécifié' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Organisateur</h4>
                    <p class="text-gray-700 dark:text-gray-300">{{ $event->organizer ?? 'Non spécifié' }}</p>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacité</h4>
                    <p class="text-gray-700 dark:text-gray-300">{{ $event->capacity ?? 'Illimitée' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="my-3 flex flex-wrap gap-3 sm:mt-0">
        @livewire('table.searchbar')
        <x-button.primary href="{{ route('admin.guests.import', ['event_id' => $event->id]) }}" responsive icon="heroicon-o-arrow-up-tray">
            {{ __('Importer') }}
        </x-button.primary>
        <x-button.primary href="{{ route('admin.guests.export', ['event_id' => $event->id]) }}" responsive icon="heroicon-o-arrow-down-tray">
            {{ __('Exporter') }}
        </x-button.primary>
        <x-button.primary href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}" responsive icon="heroicon-o-plus">
            {{ __('Ajouter des invités') }}
        </x-button.primary>
    </div>
    <livewire:pages.guests.table :event="$event" />
</x-app-layout>
