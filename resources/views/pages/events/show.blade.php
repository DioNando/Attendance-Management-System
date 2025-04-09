<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Détails d'un événement" />
    </x-slot>

    <!-- Event Information Card -->
    <div class="flex flex-wrap gap-6 mb-6">
        <div
            class="flex-auto w-fit overflow-hidden bg-white dark:bg-gray-900 sm:rounded-lg border border-gray-300 dark:border-gray-700">
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
                </div>

                @if ($event->description)
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
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ $event->organizer ? $event->organizer->first_name . ' ' . $event->organizer->last_name : 'Non spécifié' }}
                        </p>
                    </div>
                </div>
                <!-- Delete event button and modal -->
                <div class="mt-4" x-data="{ openDeleteModal: false }">
                    <x-button.primary color="gray" type="button" @click="openDeleteModal = true">Supprimer
                        l'événement</x-button.primary>

                    <!-- Modal de confirmation pour suppression -->
                    <div x-show="openDeleteModal" x-cloak
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/75 transition-opacity"
                        role="alertdialog" aria-labelledby="modal-title" aria-describedby="modal-description"
                        aria-modal="true" @keydown.escape.window="openDeleteModal = false">
                        <div x-transition
                            class="relative sm:w-full sm:max-w-lg overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl sm:p-6 p-4">

                            <!-- Header -->
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:size-10">
                                    <x-heroicon-o-exclamation-triangle class="size-6 text-red-600" />
                                </div>
                                <h3 id="modal-title" class="text-base font-semibold text-gray-900 dark:text-white">
                                    Supprimer l'événement
                                    {{ $event->name }}
                                </h3>
                            </div>

                            <!-- Body -->
                            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                <p>Êtes-vous sûr de vouloir supprimer cet événement ?
                                    Cette action est irréversible et supprimera également tous les invités associés.</p>
                            </div>

                            <!-- Actions -->
                            <div class="mt-5 sm:mt-4 flex flex-row-reverse gap-3">
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button.primary type="submit" color="red">Supprimer</x-button.primary>
                                </form>
                                <div @click="openDeleteModal = false">
                                    <x-button.outlined type="button" color="gray">Annuler</x-button.outlined>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <livewire:pages.guests.import :event="$event" />
    </div>

    <div class="my-3 flex items-start flex-wrap gap-3 sm:mt-0">
        <livewire:table.searchbar />
        <livewire:pages.guests.export :event="$event" />
        <livewire:pages.guests.send-invitations :event="$event" />
        <x-button.primary href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}" responsive
            icon="heroicon-o-plus">
            {{ __('Ajouter des invités') }}
        </x-button.primary>
    </div>
    <livewire:pages.guests.table :event="$event" />
</x-app-layout>
