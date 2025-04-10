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
                            <x-table.cell>
                                <div class="flex items-center">
                                    <span class="font-medium">{{ $scan['guest']['first_name'] }}
                                        {{ $scan['guest']['last_name'] }}</span>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div>
                                    <div class="flex items-center mb-1">
                                        <x-heroicon-o-qr-code class="size-5 text-blue-500 dark:text-blue-400 mr-2" />
                                        <span class="text-sm text-blue-600 dark:text-blue-400">QR Code</span>
                                    </div>
                                    {{-- <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $scan['guest']['qr_code'] }}"
                                        alt="QR Code pour {{ $scan['guest']['first_name'] }} {{ $scan['guest']['last_name'] }}"
                                        class="w-20 h-20 flex-shrink-0 p-1 border-2 border-gray-200 dark:border-gray-700" /> --}}
                                    <div class="mt-1 text-xs text-gray-700 dark:text-gray-400">
                                        {{ $scan['guest']['qr_code'] }}</div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center">
                                    <x-badge.item text="{{ $scan['created_at'] }}" color="green" />
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex flex-col gap-1">
                                    <span class="font-medium">{{ $scan['scanned_by_name'] }}</span>
                                    @if (isset($scan['scanned_by_role']))
                                        @php
                                            $roleColors = [
                                                'Administrateur' => 'red',
                                                'Organisateur' => 'blue',
                                                'Staff' => 'green',
                                                'Scanner' => 'yellow',
                                                'Invité' => 'gray',
                                            ];
                                            $roleColor = $roleColors[$scan['scanned_by_role']->label()] ?? 'gray';
                                        @endphp
                                        <div>
                                            <x-badge.item :text="$scan['scanned_by_role']->label()" :color="$roleColor" />
                                        </div>
                                    @endif
                                </div>
                            </x-table.cell>
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
