<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Profile" />
    </x-slot>

    <div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</x-app-layout>
