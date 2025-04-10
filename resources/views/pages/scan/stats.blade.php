<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex flex-col gap-2">
                <h3 class="flex items-center gap-2 text-2xl font-bold text-blue-600 dark:text-blue-400">
                    {{ __('Statistiques de l\'événement') }}
                </h3>
                <div class="flex items-center">
                    <x-badge.item :text="$event->name" color="blue" />
                </div>
            </div>
            <div>
                <x-button.primary href="{{ route('scan.index', $event) }}" icon="heroicon-o-arrow-left" responsive>
                    Retour au scan
                </x-button.primary>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto">
        <!-- Cartes de statistiques -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Carte 1: Invités totaux -->
            <x-dashboard.stat-card title="Total invités" :value="$stats['totalGuests']" icon="heroicon-o-users" iconColor="blue" />

            <!-- Carte 2: Présence -->
            <x-dashboard.stat-card title="Présents" :value="$stats['presentGuests']" icon="heroicon-o-check-badge" iconColor="green" />

            <!-- Carte 3: Absents -->
            <x-dashboard.stat-card title="Absents" :value="$stats['totalGuests'] - $stats['presentGuests']" icon="heroicon-o-x-mark" iconColor="red" />

            <!-- Carte 4: Invitations -->
            @php
                $sentCount = $event->guests()->where('invitation_sent', true)->count();
                $sentPercent = $stats['totalGuests'] > 0 ? round(($sentCount / $stats['totalGuests']) * 100) : 0;
            @endphp
            <x-dashboard.stat-card title="Invitations envoyées" :value="$sentCount" icon="heroicon-o-envelope"
                iconColor="indigo" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Graphique des arrivées par heure -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 ">
                <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Arrivées par heure</h2>
                <div class="h-64">
                    <!-- Graphique à barres simple -->
                    <div class="flex h-full items-end space-x-2">
                        @foreach (range(8, 20) as $hour)
                            @php
                                $count = $stats['arrivalsByHour'][$hour] ?? 0;
                                $max = count($recentArrivals) > 0 ? max($stats['arrivalsByHour']) : 1;
                                $height = $count > 0 ? ($count / $max) * 100 : 0;
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-t"
                                    style="height: {{ $height }}%"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $hour }}h</span>
                                <span class="text-xs font-semibold">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Liste des arrivées récentes -->
            <div class="bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 ">
                <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Arrivées récentes</h2>
                <div class="overflow-y-auto max-h-64">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentArrivals as $arrival)
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $arrival->guest->first_name }} {{ $arrival->guest->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $arrival->created_at->format('H:i') }} -
                                            {{ $arrival->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <x-badge.item text="Présent" color="green" />
                                </div>
                            </li>
                        @empty
                            <li class="py-3 text-center text-gray-500 dark:text-gray-400">
                                Aucune arrivée récente
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Taux de présence -->
        <div class="mt-8 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 ">
            <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Taux de présence</h2>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mr-2">
                    <div class="bg-green-600 h-4 rounded-full" style="width: {{ $stats['percentPresent'] }}%"></div>
                </div>
                <span
                    class="text-2xl font-medium text-gray-700 dark:text-gray-300 text-right">{{ $stats['percentPresent'] }}%</span>
            </div>
        </div>

        <!-- Statistiques détaillées -->
        <div class="mt-8 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-700 p-6 ">
            <h2 class="text-lg font-semibold text-blue-600 dark:text-blue-400 mb-4">Statistiques détaillées</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Détails de présence -->
                <div>
                    <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Présence</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nombre</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Pourcentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-green-400"></span>
                                        Présents
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $stats['presentGuests'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $stats['percentPresent'] }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-red-400"></span>
                                        Absents
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ $stats['totalGuests'] - $stats['presentGuests'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    {{ 100 - $stats['percentPresent'] }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">Total</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $stats['totalGuests'] }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Détails des invitations -->
                <div>
                    <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Invitations</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nombre</th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Pourcentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $sentCount = $event->guests()->where('invitation_sent', true)->count();
                                $notSentCount = $event->guests()->where('invitation_sent', false)->count();
                                $sentPercent =
                                    $stats['totalGuests'] > 0 ? round(($sentCount / $stats['totalGuests']) * 100) : 0;
                                $notSentPercent =
                                    $stats['totalGuests'] > 0
                                        ? round(($notSentCount / $stats['totalGuests']) * 100)
                                        : 0;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-indigo-400"></span>
                                        Envoyées
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $sentCount }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $sentPercent }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                    <div class="flex items-center">
                                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-gray-400"></span>
                                        Non envoyées
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $notSentCount }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $notSentPercent }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">Total</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $stats['totalGuests'] }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
