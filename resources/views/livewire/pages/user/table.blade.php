@if (session('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('message') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@php
    $headers = ['Nom', 'Email', 'Rôle', 'Date de création', 'Actions'];
    $empty = 'Aucun utilisateur trouvé';
@endphp

<div>
    <x-table.group :headers="$headers">
        <x-table.body class="bg-white dark:bg-gray-900">
            @forelse($users as $user)
                <tr>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span class="font-medium">{{ $user->last_name }} {{ $user->first_name }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span class="text-gray-700 dark:text-gray-400">{{ $user->email }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        {{-- <div class="flex items-center">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                    'organizer' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'staff' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'scanner' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                ];
                                $roleIcons = [
                                    'admin' => 'shield',
                                    'organizer' => 'user-group',
                                    'staff' => 'clipboard-document-list',
                                    'scanner' => 'qr-code',
                                ];
                                $roleColor = $roleColors[$user->role->label()] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                $roleIcon = $roleIcons[$user->role->label()] ?? 'user';
                            @endphp
                            <span class="flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full {{ $roleColor }}">
                                <x-dynamic-component :component="'heroicon-o-' . $roleIcon" class="size-4" />
                                {{ ucfirst($user->role->label()) }}
                            </span>
                        </div> --}}
                        <div class="flex items-center">
                            <span
                                class="flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ $user->role->label() }}
                            </span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') }}</span>

                        </div>
                    </x-table.cell>
                    <x-table.cell class="w-fit px-5 text-sm">
                        <div class="flex gap-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="text-gray-700 dark:text-gray-300 hover:text-orange-500">Modifier</a>
                            @if (auth()->id() !== $user->id)
                                <div x-data="{ openDeleteModal: false }">
                                    <button @click="openDeleteModal = true"
                                        class="text-red-700 dark:text-red-300 hover:text-red-500">Supprimer</button>

                                    <!-- Modal de confirmation pour suppression -->
                                    <div x-show="openDeleteModal" x-cloak
                                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-500/75 transition-opacity"
                                        role="alertdialog" aria-labelledby="modal-title"
                                        aria-describedby="modal-description" aria-modal="true"
                                        @keydown.escape.window="openDeleteModal = false">
                                        <div x-transition
                                            class="relative sm:w-full sm:max-w-lg overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow-xl sm:p-6 p-4">

                                            <!-- Header -->
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 sm:size-10">
                                                    <x-heroicon-o-exclamation-triangle class="size-6 text-red-600" />
                                                </div>
                                                <h3 id="modal-title"
                                                    class="text-base font-semibold text-gray-900 dark:text-white">
                                                    Supprimer
                                                    {{ $user->first_name . ' ' . $user->last_name }}
                                                </h3>
                                            </div>

                                            <!-- Body -->
                                            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                                <p>Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                                    Cette action est irréversible.</p>
                                            </div>

                                            <!-- Actions -->
                                            <div class="mt-5 sm:mt-4 flex flex-row-reverse gap-3">
                                                <button wire:click="deleteUser({{ $user->id }})"
                                                    @click="openDeleteModal = false"
                                                    class="inline-flex justify-center items-center px-4 py-2 border border-transparent font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Supprimer
                                                </button>
                                                <div @click="openDeleteModal = false">
                                                    <x-button.outlined type="button"
                                                        color="gray">Annuler</x-button.outlined>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-table.cell>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) }}" class="text-center py-5 text-gray-500 dark:text-gray-400">
                        {{ $empty }}
                    </td>
                </tr>
            @endforelse
        </x-table.body>
    </x-table.group>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

</div>
