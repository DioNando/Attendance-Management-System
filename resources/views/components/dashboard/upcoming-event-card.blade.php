@props(['event'])

<div
    class="overflow-hidden rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 transition-shadow hover:shadow-lg">
    <div class="bg-blue-200 dark:bg-gray-800 p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-2 items-center justify-between">
            <h4 class="text-lg font-bold text-blue-900 dark:text-blue-400 flex gap-2 items-center">
                <x-heroicon-o-calendar-days class="hidden md:block w-5 h-5" />
                {{ $event->name }}
                @php
                    $daysUntil = now()->diffInDays($event->start_date, false);
                @endphp
                @if ($daysUntil > 0)
                    <x-badge.item text="Dans {{ floor($daysUntil) }} jour{{ floor($daysUntil) > 1 ? 's' : '' }}"
                        color="blue" class="ml-3" />
                @else
                    <x-badge.item text="Aujourd'hui" color="green" class="ml-3" />
                @endif
            </h4>
            <div class="flex gap-3">
                <a href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}"
                    class="inline-flex items-center p-2 text-sm text-white rounded-lg bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800">
                    <x-heroicon-o-user-plus class="w-4 h-4" />
                </a>
                <a href="{{ route('admin.events.show', $event) }}"
                    class="inline-flex items-center p-2 text-sm text-white rounded-lg bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800">
                    <x-heroicon-o-eye class="w-4 h-4" />
                </a>
            </div>
        </div>
    </div>
    <div class="p-4">
        <div class="mb-4">
            <p class="mb-1 text-sm text-gray-600 dark:text-gray-400 line-clamp-1" title="{{ $event->description }}">
                {{ $event->description ?: 'Aucune description' }}
            </p>
        </div>

        <dl class="space-y-2">
            <div class="flex items-center text-sm">
                <dt class="flex items-center text-gray-500 dark:text-gray-400 w-8">
                    <x-heroicon-o-map-pin class="h-4 w-4" />
                </dt>
                <dd class="text-gray-700 dark:text-gray-300">
                    {{ $event->location ?: 'Non spécifié' }}
                </dd>
            </div>

            <div class="flex items-center text-sm">
                <dt class="flex items-center text-gray-500 dark:text-gray-400 w-8">
                    <x-heroicon-o-calendar class="h-4 w-4" />
                </dt>
                <dd class="text-gray-700 dark:text-gray-300">
                    {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                </dd>
            </div>

            <div class="flex items-center text-sm">
                <dt class="flex items-center text-gray-500 dark:text-gray-400 w-8">
                    <x-heroicon-o-user-group class="h-4 w-4" />
                </dt>
                <dd class="text-gray-700 dark:text-gray-300">
                    {{ $event->guests_count }}
                    invité{{ $event->guests_count > 1 ? 's' : '' }}
                </dd>
            </div>
        </dl>
    </div>
</div>
