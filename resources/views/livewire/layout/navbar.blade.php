<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div
    class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-xs
        sm:gap-x-6 sm:px-6 lg:px-8
        dark:border-gray-700 dark:bg-gray-800">

    <button @click="open = true" type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden dark:text-gray-300">
        <span class="sr-only">Ouvrir</span>
        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
            data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
    </button>

    <!-- Separator -->
    <div class="h-6 w-px bg-gray-200 lg:hidden dark:bg-gray-700" aria-hidden="true"></div>

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        {{-- ? @livewire('base.search') --}}
        <div class="flex-1"></div>
        <div class="flex items-center gap-x-4 lg:gap-x-6">
            <div x-data="{ theme: localStorage.getItem('theme') || 'system' }"
                class="p-4 relative flex items-center justify-center text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-100">
                <button x-show="theme === 'dark' || theme === 'system'" x-cloak
                    @click="theme = 'light'; localStorage.setItem('theme', 'light'); document.documentElement.setAttribute('data-theme', 'light')"
                    class="absolute">
                    <x-heroicon-o-sun class="size-6" />
                </button>
                <button x-show="theme === 'light'" x-cloak
                    @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); document.documentElement.setAttribute('data-theme', 'dark')"
                    class="absolute">
                    <x-heroicon-o-moon class="size-6" />
                </button>
            </div>
            @livewire('base.notifications')

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200 dark:bg-gray-700" aria-hidden="true"></div>

            <!-- Profile dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" @click.away="open = false" type="button"
                    class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false"
                    aria-haspopup="true">
                    <span class="sr-only">Ouvrir le menu</span>
                    {{-- <img class="size-8 rounded-full bg-gray-50 dark:bg-gray-700"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                    <div
                        class="size-8 bg-gray-700 rounded-full text-gray-100 text-xl flex items-center justify-center">
                        <span x-text="T"></span>
                    </div> --}}
                    <span class="flex lg:items-center">
                        <span class="flex-shrink-0 ml-4 text-sm/6 font-semibold text-gray-900 dark:text-gray-200" aria-hidden="true"
                            x-data="{{ json_encode(['nom' => auth()->user()->nom]) }}" x-text="nom"
                            x-on:profile-updated.window="nom = $event.detail.nom"></span>
                        <svg class="ml-2 size-5 text-gray-400 dark:text-gray-500" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>

                <div x-show="open" x-cloak
                    class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white overflow-hidden ring-1 shadow-lg ring-gray-900/5 focus:outline-hidden
                        dark:bg-gray-800 dark:ring-gray-700 dark:shadow-gray-900"
                    role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <!-- Active: "bg-gray-50 outline-hidden", Not Active: "" -->
                    <a href="{{ route('profile') }}" wire:navigate
                        class="block px-3 py-1 text-sm/6 text-gray-900 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                        role="menuitem" tabindex="-1" id="user-menu-item-0">Mon profil</a>
                    <a wire:click="logout"
                        class="block px-3 py-1 text-sm/6 text-gray-900 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-700"
                        role="menuitem" tabindex="-1" id="user-menu-item-1">Déconnexion</a>
                </div>
            </div>
        </div>
    </div>
</div>
