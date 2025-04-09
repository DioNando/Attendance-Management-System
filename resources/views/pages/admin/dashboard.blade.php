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
                        <span
                            class="text-sm text-gray-500 dark:text-gray-400">{{ \App\Enums\UserRole::tryFrom(auth()->user()->role->value)?->label() ?? auth()->user()->role }}</span>
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

            {{-- Total Events --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total des événements</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalEvents }}</p>
                    </div>
                    <div class="rounded-full bg-blue-100 p-3 dark:bg-blue-900">
                        <x-heroicon-o-calendar-days class="h-6 w-6 text-blue-600 dark:text-blue-400" />
                    </div>
                </div>
            </div>

            {{-- Upcoming Events --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Événements à venir</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $upcomingEvents }}</p>
                    </div>
                    <div class="rounded-full bg-indigo-100 p-3 dark:bg-indigo-900">
                        <x-heroicon-o-clock class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                </div>
            </div>

            {{-- Ongoing Events --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Événements en cours</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $ongoingEvents }}</p>
                    </div>
                    <div class="rounded-full bg-green-100 p-3 dark:bg-green-900">
                        <x-heroicon-o-play class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                </div>
            </div>

            {{-- Attendance Rate --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Taux de présence</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $attendanceRate }}%</p>
                    </div>
                    <div class="rounded-full bg-yellow-100 p-3 dark:bg-yellow-900">
                        <x-heroicon-o-user-group class="h-6 w-6 text-yellow-600 dark:text-yellow-400" />
                    </div>
                </div>
            </div>
        </div>

        {{-- Graphiques et Détails --}}
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            {{-- Graphique de répartition des événements --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Répartition des événements</h3>
                <div class="h-64 rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                    <div class="flex h-full items-end justify-around">
                        <div class="flex w-1/3 flex-col items-center">
                            <div class="mb-2 h-full w-16 rounded bg-blue-500 dark:bg-blue-600"
                                style="height: {{ $upcomingEvents > 0 ? ($upcomingEvents / $totalEvents) * 100 : 0 }}%">
                            </div>
                            <span class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400">À venir</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $upcomingEvents }}</span>
                        </div>
                        <div class="flex w-1/3 flex-col items-center">
                            <div class="mb-2 h-full w-16 rounded bg-green-500 dark:bg-green-600"
                                style="height: {{ $ongoingEvents > 0 ? ($ongoingEvents / $totalEvents) * 100 : 0 }}%">
                            </div>
                            <span class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400">En cours</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $ongoingEvents }}</span>
                        </div>
                        <div class="flex w-1/3 flex-col items-center">
                            <div class="mb-2 h-full w-16 rounded bg-gray-400 dark:bg-gray-500"
                                style="height: {{ $pastEvents > 0 ? ($pastEvents / $totalEvents) * 100 : 0 }}%">
                            </div>
                            <span class="mt-2 text-sm font-medium text-gray-600 dark:text-gray-400">Terminés</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $pastEvents }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Graphique des invités par événement --}}
            <div class="rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Top 5 des événements par invités
                </h3>
                <div class="h-64 overflow-hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
                    @php
                        $topEvents = \App\Models\Event::withCount('guests')
                            ->orderBy('guests_count', 'desc')
                            ->take(5)
                            ->get();

                        $maxGuests = $topEvents->max('guests_count') ?: 1;
                    @endphp
                    <div class="flex h-full items-end space-x-2">
                        @foreach ($topEvents as $event)
                            <div class="flex h-full flex-1 flex-col items-center justify-end">
                                <div class="mb-2 w-full rounded bg-indigo-500 dark:bg-indigo-600"
                                    style="height: {{ ($event->guests_count / $maxGuests) * 100 }}%">
                                </div>
                                <div class="w-full overflow-hidden text-center">
                                    <span class="block truncate text-xs font-medium text-gray-600 dark:text-gray-400"
                                        title="{{ $event->name }}">
                                        {{ \Illuminate\Support\Str::limit($event->name, 10) }}
                                    </span>
                                    <span
                                        class="text-xs font-bold text-gray-900 dark:text-white">{{ $event->guests_count }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Événements à venir (Cards) --}}
        <div class="mt-8">
            <h3 class="mb-6 text-xl font-bold text-gray-900 dark:text-white">Événements à venir</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @php
                    $upcomingEventsList = \App\Models\Event::where('start_date', '>', $today)
                        ->orderBy('start_date', 'asc')
                        ->take(8)
                        ->withCount('guests')
                        ->get();
                @endphp

                @forelse($upcomingEventsList as $event)
                    <div
                        class="overflow-hidden rounded-lg bg-white shadow-md transition-all hover:shadow-lg dark:bg-gray-800">
                        <div class="bg-blue-100 p-4 dark:bg-blue-900">
                            <div class="flex items-center justify-between">
                                <h4 class="font-semibold text-blue-800 dark:text-blue-300">{{ $event->name }}</h4>
                                @php
                                    $daysUntil = now()->diffInDays($event->start_date, false);
                                @endphp
                                @if ($daysUntil > 0)
                                    <span
                                        class="rounded-full bg-blue-200 px-2 py-1 text-xs font-medium text-blue-800 dark:bg-blue-800 dark:text-blue-200">
                                        Dans {{ floor($daysUntil) }} jour{{ floor($daysUntil) > 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-green-200 px-2 py-1 text-xs font-medium text-green-800 dark:bg-green-800 dark:text-green-200">
                                        Aujourd'hui
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="mb-4">
                                <p class="mb-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2"
                                    title="{{ $event->description }}">
                                    {{ $event->description ?: 'Aucune description' }}
                                </p>
                            </div>
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <x-heroicon-o-map-pin class="mr-1 h-4 w-4" />
                                <span>{{ $event->location ?: 'Non spécifié' }}</span>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <x-heroicon-o-calendar class="mr-1 h-4 w-4" />
                                <span>{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <x-heroicon-o-user-group class="mr-1 h-4 w-4" />
                                <span>{{ $event->guests_count }}
                                    invité{{ $event->guests_count > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}"
                                    class="rounded-md bg-green-600 px-3 py-1.5 text-sm font-medium text-white transition-colors hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 flex items-center">
                                    <x-heroicon-o-user-plus class="mr-1 h-4 w-4" />
                                    Ajouter invité
                                </a>
                                <a href="{{ route('admin.events.show', $event) }}"
                                    class="rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white transition-colors hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                                    Consulter
                                </a>
                            </div>
                        </div>
                    </div>
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
                        class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Voir tous les événements
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-app-layout>
