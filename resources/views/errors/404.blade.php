@extends('layouts.auth')

@section('content')
    <main class="grid min-h-full place-items-center px-6 py-24 sm:py-32 lg:px-8 bg-gray-100 dark:bg-gray-800">
        <div class="text-center">
            <div class="relative">
                <p class="text-9xl font-bold text-blue-600/20 absolute inset-0 -z-10">404</p>
                <p class="text-4xl font-semibold text-blue-600 relative">404</p>
            </div>
            <h1 class="mt-4 text-balance text-5xl font-semibold tracking-tight text-gray-900 sm:text-7xl dark:text-gray-100">
                Page introuvable
            </h1>
            <p class="mt-6 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8 dark:text-gray-300">
                Désolé, nous n'avons pas pu trouver la page "{{ request()->path() }}" que vous recherchez.
            </p>

            <div class="mt-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Pages populaires</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
                    <a href="{{ route('dashboard.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-home class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Tableau de bord</span>
                        </div>
                    </a>
                    <a href="{{ route('collaborateurs.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-users class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Collaborateurs</span>
                        </div>
                    </a>
                    <a href="{{ route('conges.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-calendar class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Congés</span>
                        </div>
                    </a>
                    <a href="{{ route('documents-administratifs.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-document-text class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Documents</span>
                        </div>
                    </a>
                    <a href="{{ route('villes.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-building-office class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Villes</span>
                        </div>
                    </a>
                    <a href="{{ route('regions.index') }}"
                        class="rounded-lg bg-white dark:bg-gray-700 p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-map class="size-6 text-blue-600" />
                            <span class="text-gray-900 dark:text-gray-100">Régions</span>
                        </div>
                    </a>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="{{ url()->previous() }}"
                    class="rounded-md bg-gray-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                    Retour à la page précédente
                </a>
                <a href="{{ route('dashboard.index') }}"
                    class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                    Retourner au tableau de bord
                </a>
            </div>
        </div>
    </main>
@endsection
