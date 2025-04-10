<div class="relative" wire:poll.10s>
    <div id="recent-scans">
        @if (count($recentScans) === 0)
            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Aucun scan récent</p>
        @else
            @php
                $headers = ['Invité', 'Code', 'Heure', 'Scanné par'];
            @endphp
            <x-table.group :headers="$headers">
                <x-table.body class="relative bg-white dark:bg-gray-900">
                    @foreach ($recentScans as $scan)
                        <x-table.row wire:key="scan-{{ $scan['id'] }}">
                            <x-table.cell
                                content="{{ $scan['guest']['first_name'] }} {{ $scan['guest']['last_name'] }}" />
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
    <div wire:loading class="absolute m-3 inset-0 flex items-center justify-center z-10">
        <div class="banter-loader">
            <div class="banter-loader__box before:bg-blue-500"></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
            <div class="banter-loader__box "></div>
        </div>

    </div>
</div>
