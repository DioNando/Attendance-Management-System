@props(['row' => []])

<tr class="border-b">
    {{-- TODO: Fix display --}}
    @foreach ($row as $cell)
        <x-table.cell :content="$cell" />
    @endforeach
</tr>
