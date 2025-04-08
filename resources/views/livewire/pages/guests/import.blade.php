<div>
    <form wire:submit="import">
        <div class="mb-4">
            <label for="guestsFile" class="block text-sm font-medium text-gray-700">
                {{ __('Fichier CSV des invités') }}
            </label>
            <x-form.file name="guestsFile" placeholder="Sélectionner un fichier CSV" accept=".csv,.txt"
                allowedTypes="CSV, TXT" maxSize="2MB" :file="$guestsFile ? $guestsFile->getClientOriginalName() : 'Aucun fichier sélectionné'" />
            @error('guestsFile')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            <p class="mt-1 text-xs text-gray-500">
                {{ __('Format attendu: CSV avec en-têtes first_name, last_name, email, phone (optionnel), company (optionnel)') }}
            </p>
        </div>

        <div class="flex items-center">
            <x-button.primary type="submit" icon="heroicon-o-arrow-up-tray"> {{ __('Importer') }}</x-button.primary>


            @if ($isImporting)
                <div class="ml-3 flex items-center text-sm text-gray-600">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('Importation en cours...') }}
                </div>
            @endif

            @if (session('message'))
                <div class="ml-3 text-sm text-green-600">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </form>
</div>
