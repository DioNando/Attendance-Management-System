<div>
    @php
        $headers = ['Nom', 'Prénom', 'Email', 'Téléphone', 'Qr Code', ''];
        $empty = 'Aucun invité trouvé';
    @endphp
    <x-table.group :headers="$headers">
        <x-table.body class="bg-white dark:bg-gray-900">
            @forelse($guests as $guest)
                <tr>
                    <x-table.cell content="{{ $guest->first_name }}" />
                    <x-table.cell content="{{ $guest->last_name }}" />
                    <x-table.cell content="{{ $guest->email }}" />
                    <x-table.cell content="{{ $guest->phone }}" />
                    <x-table.cell content="{{ $guest->qr_code }}" />
                    <x-table.cell class="w-fit px-5">
                        <div class="flex gap-3 justify-center">
                            <a href="{{ route('admin.guests.edit', $event->id) }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-orange-500">Modifier</a>
                            <a href="{{ route('admin.guests.show', $event) }}"
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
    {{-- <div class="flex justify-end mt-4">
        @if ($guests->hasPages())
            {{ $guests->links() }}
        @endif
    </div> --}}
</div>
