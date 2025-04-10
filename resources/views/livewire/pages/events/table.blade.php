@php
    $headers = ['Nom', 'Description', 'Localisation', 'Invités', 'Avancées', 'Debut', 'Fin', 'Durée', ''];
    $empty = 'Aucun evenement trouvé';
@endphp
<div>
    <x-table.group :headers="$headers">
        <x-table.body class="bg-white dark:bg-gray-900">
            @forelse($events as $event)
                <tr>
                    <x-table.cell>
                        <div class="flex items-center">
                            <x-heroicon-o-calendar-days class="size-5 text-blue-500 dark:text-blue-400 mr-2" />
                            <span class="font-medium">{{ $event->name }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span
                                class="truncate max-w-[150px] text-gray-700 dark:text-gray-400">{{ $event->description }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            {{-- <x-heroicon-o-map-pin class="size-5 text-gray-500 dark:text-gray-400 mr-2" /> --}}
                            <span
                                class="text-gray-700 dark:text-gray-400">{{ $event->location ?: 'Non renseigné' }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}"
                                class="flex items-center text-blue-700 dark:text-blue-300 hover:text-blue-500">
                                <x-heroicon-o-plus-circle class="size-4 mr-1" />
                                <span>Ajouter</span>
                            </a>
                            <div class="flex items-center">
                                <span class="text-base font-medium">{{ $event->guests_count }}</span>
                            </div>

                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-col space-y-2">
                            @if($event->guests_count > 0)
                                @php
                                    $presentCount = $event->attendances()->count();
                                    $presentPercent = round(($presentCount / $event->guests_count) * 100);

                                    $sentCount = $event->guests()->where('invitation_sent', true)->count();
                                    $sentPercent = round(($sentCount / $event->guests_count) * 100);
                                @endphp

                                <!-- Statistiques de présence -->
                                <div class="w-full">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="flex items-center gap-1">
                                            <x-heroicon-o-check-badge class="h-3 w-3 text-green-500" />
                                            <span>Présence</span>
                                        </span>
                                        <span>{{ $presentCount }}/{{ $event->guests_count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-green-600 h-1.5 rounded-full" style="width: {{ $presentPercent }}%"></div>
                                    </div>
                                </div>

                                <!-- Statistiques d'invitations -->
                                <div class="w-full">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="flex items-center gap-1">
                                            <x-heroicon-o-envelope class="h-3 w-3 text-blue-500" />
                                            <span>Invitations</span>
                                        </span>
                                        <span>{{ $sentCount }}/{{ $event->guests_count }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $sentPercent }}%"></div>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs text-gray-500 dark:text-gray-400">Aucun invité</span>
                            @endif
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            {{-- <x-heroicon-o-calendar class="size-5 text-emerald-500 dark:text-emerald-400 mr-2" /> --}}
                            <span>{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            {{-- <x-heroicon-o-calendar class="size-5 text-red-500 dark:text-red-400 mr-2" /> --}}
                            <span>{{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            {{-- <x-heroicon-o-clock class="size-4 text-yellow-500 dark:text-yellow-400 mr-2" /> --}}
                            @if ($event->end_date)
                                <x-badge.item
                                    text="{{ \Carbon\Carbon::parse($event->start_date)->diffForHumans(\Carbon\Carbon::parse($event->end_date), ['parts' => 1, 'short' => true]) }}"
                                    color="yellow" />
                            @else
                                <x-badge.item
                                    text="{{ \Carbon\Carbon::parse($event->start_date)->diffForHumans(now(), ['parts' => 1, 'short' => true]) }}"
                                    color="yellow" />
                            @endif
                        </div>
                    </x-table.cell>
                    <x-table.cell class="w-fit px-5 text-sm">
                        <div class="flex gap-3 justify-center">
                            <a href="{{ route('admin.events.edit', $event->id) }}"
                                class="flex items-center text-gray-700 dark:text-gray-300 hover:text-orange-500">
                                Modifier
                            </a>
                            <a href="{{ route('admin.events.show', $event) }}"
                                class="flex items-center text-blue-700 dark:text-blue-300 hover:text-blue-500">
                                Consulter
                            </a>
                        </div>
                    </x-table.cell>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="text-center py-5 text-gray-500 dark:text-gray-400">
                        {{ $empty }}
                    </td>
                </tr>
            @endforelse
        </x-table.body>
    </x-table.group>
    {{-- @if ($events->isNotEmpty())
        <nav class="py-6">
            {{ $events->links() }}
        </nav>
    @endif --}}
</div>
