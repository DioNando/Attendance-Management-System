{{-- Ce composant affiche les messages flash de session --}}
<div>
    @if (session('success'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 flex items-center p-4 mb-4 text-white rounded-lg bg-green-600 shadow-lg">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                <x-heroicon-o-check-circle class="w-5 h-5" />
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('success') }}</div>
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-700 hover:bg-green-800 text-white rounded-lg focus:ring-2 focus:ring-green-500 p-1.5 inline-flex h-8 w-8">
                <span class="sr-only">Fermer</span>
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
    @endif

    @if (session('error'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 6000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 flex items-center p-4 mb-4 text-white rounded-lg bg-red-600 shadow-lg">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                <x-heroicon-o-x-circle class="w-5 h-5" />
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('error') }}</div>
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-700 hover:bg-red-800 text-white rounded-lg focus:ring-2 focus:ring-red-500 p-1.5 inline-flex h-8 w-8">
                <span class="sr-only">Fermer</span>
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
    @endif

    @if (session('info'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 4000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 flex items-center p-4 mb-4 text-white rounded-lg bg-blue-600 shadow-lg">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg">
                <x-heroicon-o-information-circle class="w-5 h-5" />
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('info') }}</div>
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg focus:ring-2 focus:ring-blue-500 p-1.5 inline-flex h-8 w-8">
                <span class="sr-only">Fermer</span>
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
    @endif

    @if (session('warning'))
        <div x-data="{ show: true }"
             x-init="setTimeout(() => show = false, 5000)"
             x-show="show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-50 flex items-center p-4 mb-4 text-white rounded-lg bg-yellow-600 shadow-lg">
            <div class="gap-3 inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-yellow-500 bg-yellow-100 rounded-lg">
                <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            </div>
            <div class="ml-3 text-sm font-normal">{{ session('warning') }}</div>
            <button @click="show = false" type="button" class="ml-auto -mx-1.5 -my-1.5 bg-yellow-700 hover:bg-yellow-800 text-white rounded-lg focus:ring-2 focus:ring-yellow-500 p-1.5 inline-flex h-8 w-8">
                <span class="sr-only">Fermer</span>
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>
    @endif
</div>
