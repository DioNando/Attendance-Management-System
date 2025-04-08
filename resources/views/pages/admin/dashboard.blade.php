<x-app-layout>
    <section class="lg:pr-80">
        {{-- * Dashboard header --}}
        <div>
            <x-slot name="header">
                <div class="flex flex-col gap-2">
                    <h3 class="flex items-center gap-2 text-2xl font-bold text-blue-600 dark:text-blue-400">
                        {{ __('Tableau de bord') }}
                    </h3>
                    <span
                        class="text-sm text-gray-500 dark:text-gray-400">{{ \App\Enums\UserRole::tryFrom(auth()->user()->role->value)?->label() ?? auth()->user()->role }}</span>
                </div>
            </x-slot>
        </div>
        {{-- * Dashboard content --}}
        <div class="hidden">
            <x-table.table :headers="['Nom', 'Description', 'Nombre', 'Statut', 'code', 'Date d\'embauche', 'Coordonnées', 'Contact', 'Action']">

            </x-table.table>
        </div>
        

    </section>
    {{-- * Activity feed  --}}
    <aside
        class="dark:bg-gray-800 lg:fixed lg:top-16 lg:right-0 lg:bottom-0 lg:w-80 lg:overflow-y-auto lg:border-l lg:border-gray-200 dark:lg:border-gray-600">
        <header
            class="flex items-center justify-between border-b border-gray-200 dark:border-gray-600 px-4 py-4 sm:px-6 sm:py-6 lg:px-8">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Flux d'activités</h2>
            <a href="#" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Voir tout</a>
        </header>
        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-600">
            {{-- @foreach ($activities as $activity)
                <x-dashboard.activity-item
                    :user="$activity['user']"
                    :time="$activity['time']"
                    :action="$activity['action']"
                    :highlight="$activity['highlight']"
                    :type="$activity['type']"
                />
            @endforeach --}}
        </ul>
    </aside>
</x-app-layout>
