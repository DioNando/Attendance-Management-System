<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js', 'resources/js/dark-mode.js'])
    @endif

    <script>
        (function() {
            const savedTheme = localStorage.getItem("theme") || "system";
            const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const theme = savedTheme === "dark" || (savedTheme === "system" && prefersDark) ? "dark" : "light";
            document.documentElement.setAttribute("data-theme", theme);
        })();
    </script>
</head>

<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-50">
    <div class="fixed right-0 p-6">
        <div x-data="{ theme: localStorage.getItem('theme') || 'system' }" class="p-4 relative flex items-center justify-center">
            <button x-show="theme === 'dark' || theme === 'system'"
                @click="theme = 'light'; localStorage.setItem('theme', 'light'); document.documentElement.setAttribute('data-theme', 'light')"
                class="absolute text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-100  cursor-pointer">
                <x-heroicon-o-sun class="size-6" />
            </button>
            <button x-show="theme === 'light'"
                @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); document.documentElement.setAttribute('data-theme', 'dark')"
                class="absolute text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-100 cursor-pointer">
                <x-heroicon-o-moon class="size-6" />
            </button>
        </div>
    </div>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="hidden sm:mx-auto sm:w-full sm:max-w-sm">
            <a href="/" wire:navigate>
                <x-application-logo class="h-10" />
            </a>
            {{-- <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight">Se connecter à votre compte</h2> --}}
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
