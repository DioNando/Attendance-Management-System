@props(['headers' => []])

<thead class="bg-blue-200 dark:bg-gray-600">
    <tr>
        @foreach ($headers as $header)
            <th scope="col" class="px-5 py-3.5 text-left text-sm font-semibold text-blue-900 dark:text-gray-100 ">
                {{ $header }}
            </th>
        @endforeach
    </tr>
</thead>
