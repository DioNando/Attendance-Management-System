@props(['count' => 0])

<div x-data="{ open: false }" class="relative flex items-center">
    <button @click="open = !open" @click.away="open = false" type="button"
        class="relative text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-gray-100">
        <span class="sr-only">Voir les notifications</span>
        <x-heroicon-o-bell class="size-6" />
        @if ($count > 0)
            <span
                class="absolute -top-1 -right-1 flex size-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-medium text-white">
                {{ $count }}
            </span>
        @endif
    </button>

    <div x-show="open" x-cloak
        class="fixed sm:absolute right-0 top-16 sm:top-5 p-3 sm:px-0 z-50 w-full sm:w-80 ">
        <div class="divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto scrollbar-none h-auto shadow-md bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
            <div class="px-4 py-3 bg-blue-200 dark:bg-gray-900">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                <!-- Notification 1 -->
                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-8 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                            <x-heroicon-o-document-text class="size-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">Nouveau document administratif</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Le document "Contrat de travail" a
                                été
                                ajouté</p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Il y a 5 minutes</p>
                        </div>
                    </div>
                </div>

                <!-- Notification 2 -->
                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-8 shrink-0 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900">
                            <x-heroicon-o-exclamation-triangle class="size-5 text-yellow-600 dark:text-yellow-400" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">Document expirant</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Le document "Carte d'identité"
                                expire
                                dans 7 jours</p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Il y a 1 heure</p>
                        </div>
                    </div>
                </div>

                <!-- Notification 3 -->
                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="flex items-start gap-3">
                        <div
                            class="flex size-8 shrink-0 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                            <x-heroicon-o-check-circle class="size-5 text-green-600 dark:text-green-400" />
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900 dark:text-white">Document validé</p>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Le document "Diplôme" a été validé
                            </p>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">Il y a 2 heures</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3">
                <a href="#"
                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                    Voir toutes les notifications
                </a>
            </div>
        </div>
    </div>
</div>
