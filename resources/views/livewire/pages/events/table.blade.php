@php
    $headers = ['Nom', 'Description', 'Localisation', 'Invités', 'Debut', 'Fin', 'Durée', ''];
    $empty = 'Aucun evenement trouvé';
@endphp
<div>
    <x-table.group :headers="$headers">
        <x-table.body class="bg-white dark:bg-gray-900">
            @forelse($events as $event)
                <tr>
                    <x-table.cell content="{{ $event->name }}" />
                    <x-table.cell content="{{ $event->description }}" />
                    <x-table.cell content="{{ $event->location }}" />
                    <x-table.cell>
                        <div class="flex items-center gap-2">
                            <span class="text-base ">{{ $event->guests_count }}</span>
                            <a href="{{ route('admin.guests.create', ['event_id' => $event->id]) }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-blue-500">
                                Ajouter
                            </a>
                        </div>
                    </x-table.cell>
                    <x-table.cell content="{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}" />
                    <x-table.cell content="{{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}" />
                    <x-table.cell>
                        @if ($event->end_date)
                            {{ \Carbon\Carbon::parse($event->start_date)->diffForHumans(\Carbon\Carbon::parse($event->end_date), ['parts' => 1, 'short' => true]) }}
                        @else
                            {{ \Carbon\Carbon::parse($event->start_date)->diffForHumans(now(), ['parts' => 1, 'short' => true]) }}
                        @endif
                    </x-table.cell>
                    <x-table.cell class="w-fit px-5 text-sm ">
                        <div class="flex gap-3 justify-center">
                            <a href="{{ route('admin.events.edit', $event->id) }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-orange-500">Modifier</a>
                            <a href="{{ route('admin.events.show', $event) }}"
                                class="text-blue-700 dark:text-blue-300 hover:text-blue-500">Consulter</a>
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
