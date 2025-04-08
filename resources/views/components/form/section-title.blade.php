@props(['title', 'description' => null])

<div>
    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h2>
    @if ($description)
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $description }}
        </p>
    @endif
</div>
