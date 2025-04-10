{{-- @section('title', 'Scanner les invités - ' . $event->name) --}}

<x-app-layout>

    <x-slot name="header">
        <x-label.page-title label="Scanner les invités" />
    </x-slot>

    <div class="mx-auto">
        <h1 class="text-2xl font-bold mb-6">Scanner les invités pour: {{ $event->name }}</h1>

        <livewire:pages.guests.scan :event="$event" />

        <!-- Derniers scans -->
        <div class="mt-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Derniers scans</h2>
                <x-button.primary href="{{ route('scan.stats', $event) }}" color="blue" icon="heroicon-o-arrow-right"
                    responsive>
                    Voir toutes les statistiques
                </x-button.primary>
            </div>

            <livewire:pages.guests.recent-scan :event="$event" />
        </div>
    </div>
</x-app-layout>
