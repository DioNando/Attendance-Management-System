{{-- Ce composant affiche les messages flash de session --}}
<div>
    @php
        $messageTypes = [
            'success' => [
                'bg' => 'bg-green-600',
                'hover' => 'bg-green-700 hover:bg-green-800',
                'focus' => 'focus:ring-green-500',
                'icon_bg' => 'bg-green-100',
                'icon_color' => 'text-green-500',
                'icon' => 'heroicon-o-check-circle',
                'timeout' => 4000
            ],
            'error' => [
                'bg' => 'bg-red-600',
                'hover' => 'bg-red-700 hover:bg-red-800',
                'focus' => 'focus:ring-red-500',
                'icon_bg' => 'bg-red-100',
                'icon_color' => 'text-red-500',
                'icon' => 'heroicon-o-x-circle',
                'timeout' => 6000
            ],
            'info' => [
                'bg' => 'bg-blue-600',
                'hover' => 'bg-blue-700 hover:bg-blue-800',
                'focus' => 'focus:ring-blue-500',
                'icon_bg' => 'bg-blue-100',
                'icon_color' => 'text-blue-500',
                'icon' => 'heroicon-o-information-circle',
                'timeout' => 4000
            ],
            'warning' => [
                'bg' => 'bg-yellow-600',
                'hover' => 'bg-yellow-700 hover:bg-yellow-800',
                'focus' => 'focus:ring-yellow-500',
                'icon_bg' => 'bg-yellow-100',
                'icon_color' => 'text-yellow-500',
                'icon' => 'heroicon-o-exclamation-triangle',
                'timeout' => 5000
            ]
        ];
    @endphp

    @foreach($messageTypes as $type => $config)
        @if(session($type))
            <div x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, {{ $config['timeout'] }})"
                 x-show="show"
                 x-transition:enter="transform ease-out duration-300 transition"
                 x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                 x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed top-6 right-8 z-50 flex items-center p-4 mb-4 text-white rounded-lg {{ $config['bg'] }} shadow-lg flex items-center gap-3">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $config['icon_color'] }} {{ $config['icon_bg'] }} rounded-lg">
                    <x-dynamic-component :component="$config['icon']" class="w-5 h-5" />
                </div>
                <div class="text-sm font-normal">{{ session($type) }}</div>
                <button @click="show = false" type="button" class="{{ $config['hover'] }} text-white rounded-lg {{ $config['focus'] }} p-1.5 inline-flex">
                    <span class="sr-only">Fermer</span>
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                </button>
            </div>
        @endif
    @endforeach
</div>
