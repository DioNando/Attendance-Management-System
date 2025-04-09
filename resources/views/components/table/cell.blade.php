@props(['content' => '', 'class' => 'py-5 px-5 text-sm whitespace-nowrap'])

<td {{ $attributes->merge(['class' => $class]) }}>
    {!! $content !!}
    {{ $slot }}
</td>
