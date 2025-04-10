@props(['events', 'maxGuests'])

<div class="rounded-lg bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Top 5 des événements par invités</h3>
    <div class="h-64 overflow-hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-700">
        <div class="flex h-full items-end space-x-2">
            @foreach ($events as $event)
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
