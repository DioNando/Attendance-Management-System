@props(['submit', 'class' => '', 'enctype' => null])

<form wire:submit.prevent="{{ $submit }}"
    {{ $attributes->merge(['class' => "$class", 'enctype' => $enctype]) }}>
    @csrf
    {{ $slot }}
</form>
