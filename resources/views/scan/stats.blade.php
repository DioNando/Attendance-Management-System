<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Statistiques de l'événement" />
    </x-slot>

    <div class="container mx-auto">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold">Statistiques pour: {{ $event->name }}</h1>
            <x-button.primary href="{{ route('scan.index', $event) }}" icon="heroicon-o-arrow-left" responsive>
                Retour au scan
            </x-button.primary>
        </div>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Carte 1: Invités totaux -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                        <x-heroicon-o-users class="w-6 h-6 text-blue-600 dark:text-blue-300" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total invités</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalGuests'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Carte 2: Présence -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                        <x-heroicon-o-check-badge class="w-6 h-6 text-green-600 dark:text-green-300" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Présents</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['presentGuests'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Taux de présence</span>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $stats['percentPresent'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $stats['percentPresent'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Carte 3: Absents -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900 mr-4">
                        <x-heroicon-o-x-mark class="w-6 h-6 text-red-600 dark:text-red-300" />
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Absents</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['totalGuests'] - $stats['presentGuests'] }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Taux d'absence</span>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ 100 - $stats['percentPresent'] }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-red-600 h-2 rounded-full" style="width: {{ 100 - $stats['percentPresent'] }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Carte 4: Invitations -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                        <x-heroicon-o-envelope class="w-6 h-6 text-purple-600 dark:text-purple-300" />
                    </div>
                    <div>
                        @php
                            $sentCount = $event->guests()->where('invitation_sent', true)->count();
                            $sentPercent = $stats['totalGuests'] > 0 ? round(($sentCount / $stats['totalGuests']) * 100) : 0;
                        @endphp
                        <p class="text-sm text-gray-500 dark:text-gray-400">Invitations envoyées</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $sentCount }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Taux d'envoi</span>
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $sentPercent }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-purple-600 h-2 rounded-full" style="width: {{ $sentPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Graphique des arrivées par heure -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Arrivées par heure</h2>
                <div class="h-64">
                    <!-- Graphique à barres simple -->
                    <div class="flex h-full items-end space-x-2">
                        @foreach(range(8, 20) as $hour)
                            @php
                                $count = $stats['arrivalsByHour'][$hour] ?? 0;
                                $max = count($recentArrivals) > 0 ? max($stats['arrivalsByHour']) : 1;
                                $height = $count > 0 ? ($count / $max) * 100 : 0;
                            @endphp
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-200 dark:bg-blue-700 rounded-t" style="height: {{ $height }}%"></div>
                                <span class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $hour }}h</span>
                                <span class="text-xs font-semibold">{{ $count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Liste des arrivées récentes -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Arrivées récentes</h2>
                <div class="overflow-y-auto max-h-64">
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentArrivals as $arrival)
                            <li class="py-3">
                                <div class="flex items-center">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $arrival->guest->first_name }} {{ $arrival->guest->last_name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $arrival->created_at->format('H:i') }} - {{ $arrival->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                        Présent
                                    </span>
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

        <!-- Statistiques détaillées -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Statistiques détaillées</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Détails de présence -->
                <div>
                    <h3 class="text-md font-medium text-gray-700 dark:text-gray-300 mb-3">Présence</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pourcentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">Présents</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $stats['presentGuests'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $stats['percentPresent'] }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">Absents</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $stats['totalGuests'] - $stats['presentGuests'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ 100 - $stats['percentPresent'] }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">Total</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $stats['totalGuests'] }}</td>
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pourcentage</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php
                                $sentCount = $event->guests()->where('invitation_sent', true)->count();
                                $notSentCount = $event->guests()->where('invitation_sent', false)->count();
                                $sentPercent = $stats['totalGuests'] > 0 ? round(($sentCount / $stats['totalGuests']) * 100) : 0;
                                $notSentPercent = $stats['totalGuests'] > 0 ? round(($notSentCount / $stats['totalGuests']) * 100) : 0;
                            @endphp
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">Envoyées</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $sentCount }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $sentPercent }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">Non envoyées</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $notSentCount }}</td>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $notSentPercent }}%</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">Total</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $stats['totalGuests'] }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">100%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
