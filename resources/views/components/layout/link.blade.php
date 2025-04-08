@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}"
    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold
        {{ request()->routeIs($route) ? 'bg-gray-100 text-blue-600 dark:bg-gray-700 dark:text-blue-300' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-300' }}">
    <x-dynamic-component :component="'heroicon-o-' . $icon"
        class="size-6 shrink-0
            {{ request()->routeIs($route) ? 'text-blue-600 dark:text-blue-300' : 'text-gray-400 group-hover:text-blue-600 dark:text-gray-500 dark:group-hover:text-blue-300' }}" />
    {{ $label }}
</a>
