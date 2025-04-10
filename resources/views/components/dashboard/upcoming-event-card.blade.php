@props(['event'])

<div
    class="overflow-hidden rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 transition-shadow hover:shadow-lg">
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
            <p class="mb-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-2" title="{{ $event->description }}">
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
