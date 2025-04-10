<div class="relative" wire:poll.10s>
    <div id="recent-scans">
        @if (count($recentScans) === 0)
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Aucun scan récent</p>
        @else
            @php
                $headers = ['Invité', 'Code', 'Heure', 'Scanné par'];
            @endphp
            <x-table.group :headers="$headers">
                <x-table.body class="bg-white dark:bg-gray-900">
                    @foreach ($recentScans as $scan)
                        <x-table.row wire:key="scan-{{ $scan['id'] }}">
                            <x-table.cell content="{{ $scan['guest']['first_name'] }} {{ $scan['guest']['last_name'] }}" />
                            <x-table.cell content="{{ $scan['guest']['qr_code'] }}" />
                            <x-table.cell content="{{ $scan['created_at'] }}" />
                            <x-table.cell content="{{ $scan['scanned_by_name'] }}" />
                        </x-table.row>
                    @endforeach
                </x-table.body>
            </x-table.group>
        @endif
    </div>
{{-- Changer style loading --}}
    <div wire:loading class="absolute inset-0 flex items-center justify-center bg-white/50 dark:bg-gray-900/50 z-10">
        <div class="flex items-center gap-2">
            <svg class="animate-spin size-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm text-gray-700 dark:text-gray-300">Chargement...</span>
        </div>
    </div>
</div>
