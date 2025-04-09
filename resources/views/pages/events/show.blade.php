<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Détails d'un événement" />
    </x-slot>

    <!-- Event Information Card -->
    <div class="flex flex-wrap gap-6 mb-6">
        {{-- CARD POUR EVENT DEBUT --}}
        <div
            class="flex-auto w-full md:w-2/3 overflow-hidden bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700">
            <div
                class="border-b border-gray-200 dark:border-gray-700 bg-blue-200 dark:bg-gray-800 p-4 flex flex-wrap justify-between items-center gap-3">
                <h2 class="text-lg font-bold text-blue-900 dark:text-blue-400 flex items-center">
                    <x-heroicon-o-calendar-days class="hidden md:block w-6 h-6 mr-2" />
                    {{ $event->name }}

                    @php
                        $today = now()->startOfDay();
                        $startDate = $event->start_date->startOfDay();
                        $endDate = $event->end_date ? $event->end_date->endOfDay() : $startDate->copy()->endOfDay();
                    @endphp

                    @if ($today->lt($startDate))
                        <span
                            class="flex-shrink-0 ml-3 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">À
                            venir</span>
                    @elseif($today->gt($endDate))
                        <span
                            class="flex-shrink-0 ml-3 px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Terminé</span>
                    @else
                        <span
                            class="flex-shrink-0 ml-3 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">En
                            cours</span>
                    @endif
                </h2>
                <div class="flex space-x-3" x-data="{ openDeleteModal: false }">
                    <a href="{{ route('admin.events.edit', $event) }}"
                        class="inline-flex items-center p-2 text-sm text-blue-700 rounded-lg bg-white/80 border border-blue-300 hover:bg-white hover:text-blue-800 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-600 dark:hover:bg-gray-700 dark:hover:text-blue-300">
                        <x-heroicon-o-pencil class="w-4 h-4" />
                    </a>
                    <button @click="openDeleteModal = true"
                        class="inline-flex items-center p-2 text-sm text-red-600 bg-white/80 rounded-lg border border-red-300 hover:bg-white hover:text-red-700 hover:border-red-600 dark:bg-gray-800 dark:text-red-400 dark:border-red-600 dark:hover:bg-red-900 dark:hover:text-red-400 dark:hover:border-red-400">
                        <x-heroicon-o-trash class="w-4 h-4" />
                    </button>
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
                    {{-- Modal de suppression --}}
                </div>
            </div>

            <div class="p-6">
                <dl class="space-y-6">
                    <!-- Event Information Accordion -->
                    <div x-data="{ open: false }">
                        <!-- Accordion Header -->
                        <button @click="open = !open" class="flex w-full items-center justify-between py-2 text-left focus:outline-none">
                            <span class="text-md font-semibold text-gray-700 dark:text-gray-300">Détails de l'événement</span>
                            <x-heroicon-o-chevron-down class="w-5 h-5 text-gray-500 dark:text-gray-400" x-bind:class="{'rotate-180': open}" />
                        </button>

                        <!-- Accordion Content -->
                        <div x-show="open" class="space-y-6">
                            <!-- Event date and time -->
                            <div>
                                <div class="flex items-center">
                                    <dt class="text-md font-semibold text-gray-700 dark:text-gray-300 w-1/3">
                                        Dates
                                    </dt>
                                    <dd class="text-gray-700 dark:text-gray-300 w-2/3">
                                        <p>Du {{ $event->start_date->format('d/m/Y') }}
                                            {{ $event->end_date ? ' au ' . $event->end_date->format('d/m/Y') : '' }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $event->end_date ? $event->start_date->diffInDays($event->end_date) + 1 . ' jour(s)' : '1 jour' }}
                                        </p>
                                    </dd>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <!-- Organizer -->
                            <div>
                                <div class="flex items-center">
                                    <dt class="text-md font-semibold text-gray-700 dark:text-gray-300 w-1/3">
                                        Organisateur
                                    </dt>
                                    <dd class="text-gray-700 dark:text-gray-300 w-2/3">
                                        {{ $event->organizer ? $event->organizer->first_name . ' ' . $event->organizer->last_name : 'Non spécifié' }}
                                        @if ($event->organizer && $event->organizer->email)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $event->organizer->email }}</p>
                                        @endif
                                    </dd>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <!-- Location -->
                            <div>
                                <div class="flex items-center">
                                    <dt class="text-md font-semibold text-gray-700 dark:text-gray-300 w-1/3">
                                        Lieu
                                    </dt>
                                    <dd class="text-gray-700 dark:text-gray-300 w-2/3">
                                        {{ $event->location ?? 'Non spécifié' }}
                                    </dd>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <!-- Stats -->
                            <div>
                                <dt class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Statistiques
                                </dt>
                                <dd class="grid grid-cols-1 gap-3">
                                    <div class="flex items-center bg-gray-50 dark:bg-gray-800 p-3 rounded">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 w-1/3">Invités</p>
                                        <p class="text-xl font-semibold text-gray-800 dark:text-gray-200 w-2/3">
                                            {{ $event->guests->count() }}</p>
                                    </div>
                                    <div class="flex items-center bg-gray-50 dark:bg-gray-800 p-3 rounded">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 w-1/3">Date de création</p>
                                        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 w-2/3">
                                            {{ $event->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </dd>
                            </div>
                        </div>
                    </div>

                    @if ($event->description)
                        <hr class="border-gray-200 dark:border-gray-700">
                        <div>
                            <dt class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Description
                            </dt>
                            <dd class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                                <p>{{ $event->description }}</p>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
        {{-- CARD POUR EVENT FIN --}}
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
