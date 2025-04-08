@props(['data' => []])

<tbody>
    @forelse ($data as $row)
        <x-table.row :row="$row" />
    @empty
        <tr>
            <td class="px-4 py-2 text-center text-gray-500">
                Aucune donnée disponible
            </td>
        </tr>
    @endforelse
</tbody>



