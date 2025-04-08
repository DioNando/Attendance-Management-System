@props([
    'document' => null,
    'icon' => true,
    'class' => '',
])

@php
    // Vérifier si le document existe et construire l'URL
$documentUrl = $document ? Storage::url($document) : null;
$documentName = $document ? basename($document) : 'Aucun document';
// $size = $document ? Storage::size($document) : '0';
// $size = number_format($size / 1024, 2) . ' KB';

// Déterminer l'extension pour choisir l'icône appropriée
$extension = $document ? pathinfo($document, PATHINFO_EXTENSION) : '';
$iconClass = match (strtolower($extension)) {
    'pdf' => 'text-red-500',
    'doc', 'docx' => 'text-blue-500',
    'txt' => 'text-gray-500',
    default => 'text-gray-400',
    };
@endphp

<li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm">
    <div class="flex w-0 flex-1 items-center">
        {{-- @if ($icon)
            <div class="{{ $iconClass }}">
                @if (strtolower($extension) === 'pdf')
                    <x-heroicon-o-paper-clip class="size-5" />
                @elseif(in_array(strtolower($extension), ['doc', 'docx']))
                    <x-heroicon-o-paper-clip class="size-5" />
                @else
                    <x-heroicon-o-paper-clip class="size-5" />
                @endif
            </div>
        @endif --}}
        <x-heroicon-o-document-text class="size-5 shrink-0 text-gray-500 dark:text-gray-400" />
        <div class="ml-4 flex min-w-0 flex-1 gap-2">
            <span class="truncate font-medium text-gray-900 dark:text-gray-300">{{ $documentName }}</span>
            {{-- <span class="shrink-0 text-gray-500 dark:text-gray-400">{{ $size }}</span> --}}
        </div>
    </div>
    <div class="ml-4 shrink-0">
        @if ($document)
            <a href="{{ $documentUrl }}" target="_blank" rel="noopener noreferrer"
                class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 hover:dark:text-blue-300 transition duration-200">
                Voir
            </a>
        @endif
    </div>
</li>
