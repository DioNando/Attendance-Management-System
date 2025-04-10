@props(['upcomingEvents', 'ongoingEvents', 'pastEvents', 'totalEvents'])

<div class="rounded-lg bg-white p-6 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
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
