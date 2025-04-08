<div x-data="{ theme: localStorage.getItem('theme') || 'system' }" class="flex gap-8 text-gray-900 dark:text-gray-100">
    <button
        @click="theme = 'light'; localStorage.setItem('theme', 'light'); document.documentElement.setAttribute('data-theme', 'light')"
        :class="theme === 'light' ? 'text-blue-500' : ''"
        class="flex items-center gap-2 py-2 text-base hover:text-blue-600">
        <x-heroicon-o-sun class="size-5" /> Clair
    </button>

    <button
        @click="theme = 'dark'; localStorage.setItem('theme', 'dark'); document.documentElement.setAttribute('data-theme', 'dark')"
        :class="theme === 'dark' ? 'text-blue-500' : ''"
        class="flex items-center gap-2 py-2 text-base hover:text-blue-600">
        <x-heroicon-o-moon class="size-5" /> Sombre
    </button>

    <button
        @click="theme = 'system'; localStorage.setItem('theme', 'system'); document.documentElement.setAttribute('data-theme', window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')"
        :class="theme === 'system' ? 'text-blue-500' : ''"
        class="flex items-center gap-2 py-2 text-base hover:text-blue-600">
        <x-heroicon-o-computer-desktop class="size-5" /> Système
    </button>
</div>
