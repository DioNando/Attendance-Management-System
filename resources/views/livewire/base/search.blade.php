<div x-data="{ open: false }" class="relative flex flex-col flex-1">
    <div class="grid flex-1 grid-cols-1">
        <input @focus="open = true" @keydown.escape.window="open = false" @click.away="open = false" type="text"
            wire:model.live.debounce.250ms="search" placeholder="Recherche"
            class="col-start-1 row-start-1 block size-full bg-white pl-8 text-base text-gray-900 outline-hidden
                placeholder:text-gray-400 sm:text-sm/6
                dark:bg-gray-800 dark:text-gray-200 dark:placeholder:text-gray-500">
        </svg>
        <x-heroicon-o-magnifying-glass
            class="pointer-events-none col-start-1 row-start-1 size-6 self-center text-gray-400 dark:text-gray-500" />
    </div>

    <div x-show="open" x-cloak class="p-3 z-10 fixed top-16 left-0 lg:left-77 w-full md:max-w-2xl">
        @if ($collaborateurs->count())
            <ul role="list"
                class="divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto h-auto shadow-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
                @foreach ($collaborateurs as $collaborateur)
                    <li x-data="{ getInitial(nom) { return nom.charAt(0).toUpperCase(); } }"
                        class="relative flex justify-between gap-x-6 px-3 py-4 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 sm:px-6">
                        <div class="flex min-w-0 gap-x-4">
                            <div>
                                <div x-data="{ getInitial(nom) { return nom.charAt(0).toUpperCase(); } }"
                                    class="size-11 overflow-hidden bg-gray-400 dark:bg-gray-700 rounded-full text-gray-100 dark:text-gray-200 text-2xl flex items-center justify-center">
                                    @if ($collaborateur->photo_profil && Storage::disk('public')->exists($collaborateur->photo_profil))
                                        <img class="h-full w-full object-cover"
                                            src="{{ Storage::url($collaborateur->photo_profil) }}"
                                            alt="{{ $collaborateur->nom }}">
                                    @else
                                        <span x-text="getInitial('{{ $collaborateur->prenom }}')"></span>
                                    @endif
                                </div>
                            </div>
                            <div class="min-w-0 flex-auto">
                                <p class="text-sm/6 font-semibold">
                                    <a href="{{ route('collaborateurs.show', $collaborateur) }}">
                                        <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                        {{ $collaborateur->nom . ' ' . $collaborateur->prenom }}
                                    </a>
                                </p>
                                <p class="text-xs/5">
                                    {{ $collaborateur->historiques_postes->first()?->poste->nom ?? 'Non assigné' }}
                                </p>
                                {{-- <p class="text-xs/5">
                                    {{ $collaborateur->historiques_postes->first()?->poste->departement->nom ?? 'Non assigné' }}
                                </p> --}}
                                <p class="flex text-xs/5">
                                    <a
                                        class="relative truncate hover:underline text-gray-400">{{ $collaborateur->email_professionnel }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="flex shrink-0 items-center gap-x-4 text-gray-400">
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                                <p class="text-xs">Consulter</p>
                            </div>
                            <x-heroicon-o-chevron-right class="size-4" />
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
