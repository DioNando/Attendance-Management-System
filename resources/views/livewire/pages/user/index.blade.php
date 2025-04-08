<div>
    <div class="mx-auto">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between mb-4 space-y-3 md:space-y-0">
                    <div class="w-full md:w-1/3 mr-2">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="w-full md:w-1/4">
                        <select wire:model.live="role"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Tous les rôles</option>
                            @foreach (\App\Enums\UserRole::cases() as $roleOption)
                                <option value="{{ $roleOption->value }}">{{ ucfirst($roleOption->label()) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

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

                <x-table.group :headers="['Nom', 'Email', 'Rôle', 'Date de création', 'Actions']">
                    {{-- <x-table.header>
                        <x-table.heading wire:click="sortBy('last_name')" sortable :direction="$sortField === 'last_name' ? $sortDirection : null">Nom</x-table.heading>
                        <x-table.heading wire:click="sortBy('email')" sortable :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
                        <x-table.heading wire:click="sortBy('role')" sortable :direction="$sortField === 'role' ? $sortDirection : null">Rôle</x-table.heading>
                        <x-table.heading wire:click="sortBy('created_at')" sortable :direction="$sortField === 'created_at' ? $sortDirection : null">Date de création</x-table.heading>
                        <x-table.heading>Actions</x-table.heading>
                    </x-table.header> --}}

                    <x-table.body>
                        @forelse($users as $user)
                            <tr>
                                <x-table.cell>{{ $user->last_name }} {{ $user->first_name }}</x-table.cell>
                                <x-table.cell>{{ $user->email }}</x-table.cell>
                                <x-table.cell>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($user->role === 'admin') bg-red-100 text-red-800
                                        @elseif($user->role === 'organizer') bg-blue-100 text-blue-800
                                        @elseif($user->role === 'staff') bg-green-100 text-green-800
                                        @elseif($user->role === 'scanner') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{-- {{ \App\Enums\UserRole::tryFrom($user->role)->label() ?? $user->role }} --}}
                                        {{ $user->role }}
                                    </span>
                                </x-table.cell>
                                <x-table.cell>{{ $user->created_at->format('d/m/Y H:i') }}</x-table.cell>
                                <x-table.cell>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </a>
                                        @if (auth()->id() !== $user->id)
                                            <button wire:click="deleteUser({{ $user->id }})"
                                                wire:confirm="Êtes-vous sûr de vouloir supprimer cet utilisateur?"
                                                class="text-red-600 hover:text-red-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </x-table.cell>
                            </tr>
                        @empty
                            <tr>
                                <x-table.cell colspan="5" class="text-center py-4">Aucun utilisateur
                                    trouvé</x-table.cell>
                            </tr>
                        @endforelse
                    </x-table.body>
                </x-table.group>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>

                <div class="mt-6">
                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Ajouter un utilisateur
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
