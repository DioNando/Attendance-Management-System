@props(['name', 'value' => 'gray'])

@php
    $colors = [
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'purple' => 'bg-purple-500',
        'yellow' => 'bg-yellow-500',
        'orange' => 'bg-orange-500',
        'red' => 'bg-red-500',
        'indigo' => 'bg-indigo-500',
        'pink' => 'bg-pink-500',
        'rose' => 'bg-rose-500',
        'gray' => 'bg-gray-500',
        'cyan' => 'bg-cyan-500',
        'emerald' => 'bg-emerald-500',
        'sky' => 'bg-sky-500',
        'amber' => 'bg-amber-500',
        'lime' => 'bg-lime-500',
        'violet' => 'bg-violet-500',
        'fuchsia' => 'bg-fuchsia-500',
        'slate' => 'bg-slate-500',
        'zinc' => 'bg-zinc-500',
        'neutral' => 'bg-neutral-500',
    ];
@endphp

<div class="flex flex-wrap gap-5">
    @foreach ($colors as $colorName => $colorClass)
        <label class="relative w-fit">
            <input wire:model.live.250ms="{{ $name }}" type="radio" name="{{ $name }}" value="{{ $colorName }}"
                class="peer sr-only"
                {{ $value === $colorName ? 'checked' : '' }}
                {{ $attributes }}>
            <div class="h-5 w-5 rounded-full {{ $colorClass }} cursor-pointer peer-checked:outline-blue-500 peer-checked:outline-2 peer-checked:scale-115 outline outline-offset-2 outline-gray-300 dark:outline-white/10 transition-all"></div>
        </label>
    @endforeach
</div>
