<x-app-layout>
    <section>
        {{-- * Dashboard header --}}
        <div>
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <div class="flex flex-col gap-2">
                        <h3 class="flex items-center gap-2 text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ __('Tableau de bord') }}
                        </h3>
                        <div class="flex items-center">
                            @php
                                $roleColors = [
                                    'Administrateur' => 'red',
                                    'Organisateur' => 'blue',
                                    'Staff' => 'green',
                                    'Scanner' => 'yellow',
                                    'Invité' => 'gray',
                                ];
                                $userRoleLabel =
                                    \App\Enums\UserRole::tryFrom(auth()->user()->role->value)?->label() ??
                                    auth()->user()->role;
                                $roleColor = $roleColors[$userRoleLabel] ?? 'gray';
                            @endphp
                            <x-badge.item :text="$userRoleLabel" :color="$roleColor" />
                        </div>
                    </div>
                    <div>
                        <x-button.primary href="{{ route('admin.events.create') }}" responsive icon="heroicon-o-plus">
                            {{ __('Ajouter un evenement') }}
                        </x-button.primary>
                    </div>
                </div>
            </x-slot>
        </div>

        {{-- * Dashboard content --}}
        <div class="mt-6 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Statistiques --}}
            @php
                $today = now()->startOfDay();
                $totalEvents = \App\Models\Event::count();
                $upcomingEvents = \App\Models\Event::where('start_date', '>', $today)->count();
                $ongoingEvents = \App\Models\Event::where('start_date', '<=', $today)
                    ->where(function ($query) use ($today) {
                        $query->where('end_date', '>=', $today)->orWhereNull('end_date');
                    })
                    ->count();
                $pastEvents = \App\Models\Event::where('end_date', '<', $today)
                    ->orWhere(function ($query) use ($today) {
                        $query->whereNull('end_date')->where('start_date', '<', $today);
                    })
                    ->count();

                $totalGuests = \App\Models\Guest::count();
                $attendedGuests = \App\Models\Attendance::count();
                $attendanceRate = $totalGuests > 0 ? round(($attendedGuests / $totalGuests) * 100) : 0;
            @endphp

            {{-- Cartes de statistiques --}}
            <x-dashboard.stat-card title="Total des événements" :value="$totalEvents" icon="heroicon-o-calendar-days"
                iconColor="blue" />

            <x-dashboard.stat-card title="Événements à venir" :value="$upcomingEvents" icon="heroicon-o-clock"
                iconColor="indigo" />

            <x-dashboard.stat-card title="Événements en cours" :value="$ongoingEvents" icon="heroicon-o-play"
                iconColor="green" />

            <x-dashboard.stat-card title="Taux de présence" value="{{ $attendanceRate }}%" icon="heroicon-o-user-group"
                iconColor="yellow" />
        </div>

        {{-- Graphiques et Détails --}}
        <div class="hidden mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Graphique de répartition des événements --}}
            <x-dashboard.event-distribution :upcomingEvents="$upcomingEvents" :ongoingEvents="$ongoingEvents" :pastEvents="$pastEvents" :totalEvents="$totalEvents" />

            {{-- Graphique des invités par événement --}}
            @php
                $topEvents = \App\Models\Event::withCount('guests')->orderBy('guests_count', 'desc')->take(5)->get();

                $maxGuests = $topEvents->max('guests_count') ?: 1;
            @endphp

            <x-dashboard.top-events :events="$topEvents" :maxGuests="$maxGuests" />
        </div>

        {{-- Événements à venir (Cards) --}}
        <div class="mt-8">
            <h3 class="mb-6 text-xl font-bold text-gray-900 dark:text-white">Événements à venir</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 ">
                @php
                    $upcomingEventsList = \App\Models\Event::where('start_date', '>', $today)
                        ->orderBy('start_date', 'asc')
                        ->take(8)
                        ->withCount('guests')
                        ->get();
                @endphp

                @forelse($upcomingEventsList as $event)
                    <x-dashboard.upcoming-event-card :event="$event" />
                @empty
                    <div class="col-span-full rounded-lg bg-gray-50 p-8 text-center dark:bg-gray-700">
                        <p class="text-gray-600 dark:text-gray-400">Aucun événement à venir</p>
                        <a href="{{ route('admin.events.create') }}"
                            class="mt-4 inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                            <x-heroicon-o-plus class="mr-2 h-5 w-5" />
                            Créer un événement
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($upcomingEventsList->count() > 0)
                <div class="mt-6 flex justify-center">
                    <a href="{{ route('admin.events.index') }}"
                        class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Voir tous les événements
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
