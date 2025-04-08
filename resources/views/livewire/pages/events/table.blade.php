    <div>
        @php
            $headers = ['Nom', 'Description', 'Localisation', 'Invités', 'Debut', 'Fin', ''];
            $empty = 'Aucun evenement trouvé';
        @endphp
        <x-table.group :headers="$headers">
            <x-table.body class="bg-white dark:bg-gray-900">
                @forelse($events as $event)
                    <tr>
                        <x-table.cell content="{{ $event->name }}" />
                        <x-table.cell content="{{ $event->description }}" />
                        <x-table.cell content="{{ $event->location }}" />
                        <x-table.cell content="{{ $event->guest }}">
                            <div>
                                <span>45</span>
                                <a href=""><x-heroicon-o-plus class="size-5" /></a>
                            </div>
                        </x-table.cell>
                        <x-table.cell
                            content="{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}" />
                        <x-table.cell
                            content="{{ \Carbon\Carbon::parse($event->end_date)->translatedFormat('d F Y') }}" />
                        <x-table.cell class="w-fit">
                            <div class="flex gap-2 justify-center">
                                <a href="{{ route('admin.events.edit', $event->id) }}"><x-heroicon-o-pencil
                                        class="size-5" /></a>
                                <a href="{{ route('admin.events.show', $event) }}"><x-heroicon-o-chevron-right
                                        class="size-5" /></a>
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
    </div>
