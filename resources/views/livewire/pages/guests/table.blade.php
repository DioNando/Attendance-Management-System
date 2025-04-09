<div>
    @php
        $headers = ['Nom', 'Prénom', 'Email', 'Téléphone', 'Qr Code', 'Invitation', ''];
        $empty = 'Aucun invité trouvé';
    @endphp
    <x-table.group :headers="$headers">
        <x-table.body class="bg-white dark:bg-gray-900">
            @forelse($guests as $guest)
                <tr>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span>{{ $guest->first_name }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span>{{ $guest->last_name }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span>{{ $guest->email }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex items-center">
                            <span>{{ $guest->phone ?: 'Non renseigné' }}</span>
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div>
                            <div class="flex items-center mb-1">
                                <x-heroicon-o-qr-code class="size-5 text-blue-500 dark:text-blue-400 mr-2" />
                                <span class="text-sm text-blue-600 dark:text-blue-400">QR Code</span>
                            </div>
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $guest->qr_code }}"
                                alt="QR Code pour {{ $guest->first_name }} {{ $guest->last_name }}"
                                class="w-20 h-20 flex-shrink-0 p-1 border-2 border-gray-200 dark:border-gray-700" />
                        </div>
                    </x-table.cell>
                    <x-table.cell>
                        <div class="flex flex-col gap-2">
                            <livewire:pages.guests.single-invitation :guest="$guest"
                                :wire:key="'invitation-'.$guest->id" />
                            <div class="flex items-center">
                                @if ($guest->invitation_sent)
                                    <div class="flex items-center text-green-600 dark:text-green-400">
                                        <x-heroicon-o-check-circle class="size-5 mr-2" />
                                        <span>Envoyé {{ $guest->invitation_sent_at->diffForHumans() }}</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-red-600 dark:text-red-400">
                                        <x-heroicon-o-x-circle class="size-5 mr-2" />
                                        <span>Non envoyé</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </x-table.cell>
                    {{-- <x-table.cell>
                        <livewire:pages.guests.single-invitation :guest="$guest"
                            :wire:key="'invitation-'.$guest->id" />
                    </x-table.cell> --}}
                    <x-table.cell class="w-fit px-5 text-sm">
                        <div class="flex gap-3 justify-center">
                            <a href="{{ route('admin.guests.edit', $guest) }}"
                                class="flex items-center text-gray-700 dark:text-gray-300 hover:text-orange-500">
                                Modifier
                            </a>
                            <div x-data="{ openDeleteModal: false }">
                                <button @click="openDeleteModal = true"
                                    class="flex items-center text-red-700 dark:text-red-300 hover:text-red-500">
                                    Supprimer
                                </button>

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
                                                {{ $guest->first_name . ' ' . $guest->last_name }}
                                            </h3>
                                        </div>

                                        <!-- Body -->
                                        <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                            <p>Êtes-vous sûr de vouloir supprimer cet invité ?
                                                Cette action est irréversible.</p>
                                        </div>

                                        <!-- Actions -->
                                        <div class="mt-5 sm:mt-4 flex flex-row-reverse gap-3">
                                            <form action="{{ route('admin.guests.destroy', $guest) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button.primary type="submit"
                                                    color="red">Supprimer</x-button.primary>
                                            </form>
                                            <div @click="openDeleteModal = false">
                                                <x-button.outlined type="button"
                                                    color="gray">Annuler</x-button.outlined>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <div class="flex justify-end mt-4">
        @if ($guests->hasPages())
            {{ $guests->links() }}
        @endif
    </div>
</div>
