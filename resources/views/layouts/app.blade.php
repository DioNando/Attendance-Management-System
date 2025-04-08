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
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/scss/app.scss', 'resources/js/dark-mode.js']) --}}
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

<body class="font-sans antialiased h-full bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-50">
    <div id="app" x-data="{ open: false }" class="flex h-full">
        {{-- <livewire:layout.navigation /> --}}
        <x-layout.sidebar />
        <!-- Page Content -->
        {{-- <div class="lg:pl-72"> --}}
        {{-- <div class="lg:w-72">
            Menu
        </div> --}}
        <div class="flex-1 overflow-auto">
            <livewire:layout.navbar />
            <main class="py-8">
                <div class="px-4 sm:px-6 lg:px-8">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <header class="mb-4">
                            {{ $header }}
                        </header>
                    @endif
                    <div>
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
        <x-alert.notification />
    </div>
</body>

</html>
