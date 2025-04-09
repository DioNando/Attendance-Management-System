@props(['items' => [], 'color' => 'blue', 'emptyText' => 'Aucun élément disponible'])

<div class="flex flex-wrap">
    @if (count($items) > 0)
        @foreach ($items as $item)
            <x-badge.item :text="ucfirst($item)" :color="$color" />
        @endforeach
    @else
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $emptyText }}</span>
    @endif
</div>
