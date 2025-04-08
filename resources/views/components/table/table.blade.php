@props(['headers' => [], 'data' => []])

<div class="flow-root">
    <div class="overflow-auto inline-block w-fit align-middle">
        <div class="overflow-hidden ring-1 ring-gray-200 dark:ring-gray-700 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-900">
                <x-table.head :headers="$headers" />
                {{-- <x-table.body :data="$data" /> --}}
                <tbody>
                    {{-- {{ $slot }} --}}
                    @forelse ($data as $row)
                    @empty
                        <tr>
                            <td colspan="{{ count($headers) }}" class="text-center py-5 text-gray-500 dark:text-gray-400">
                                Aucune donnée disponible
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
