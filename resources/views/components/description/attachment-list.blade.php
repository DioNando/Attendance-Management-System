@props(['label' => 'Pièces jointes', 'attachments'])

<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
    <dt class="text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</dt>
    <dd class="mt-2 text-sm text-gray-900 dark:text-gray-300 sm:col-span-2 sm:mt-0">
        <ul role="list"
            class="divide-y divide-gray-100 dark:divide-gray-700 rounded-md border border-gray-200 dark:border-gray-700">
            {{-- @foreach ($attachments as $attachment)
                <x-description.attachment-item :file="$attachment['file']" />
                @endforeach --}}
            <x-description.attachment-item :document="$attachments" />
        </ul>
    </dd>
</div>
