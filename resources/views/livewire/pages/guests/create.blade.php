<x-form.form submit="store">
    <div class="mt-5 md:max-w-md bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-700 rounded-lg p-8">
        <h3 class="text-xl font-medium mb-3">Evénement : {{ $event->name }}</h3>
        <div class="grid grid-cols-1 border-b border-gray-900/10 dark:border-gray-700 pb-12">
            <div class="flex flex-col gap-x-6 gap-y-8">
                <div class="sm:col-span-full">
                    <x-form.group name="form.last_name" label="Nom" required>
                        <x-form.input name="form.last_name" :live="true" required />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.first_name" label="Prénom" required>
                        <x-form.input name="form.first_name" :live="true" required />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.email" label="Email" required>
                        <x-form.input type="email" name="form.email" :live="true" required />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.phone" label="Téléphone">
                        <x-form.input name="form.phone" />
                    </x-form.group>
                </div>
                {{-- <div class="sm:col-span-full">
                    <x-form.group name="form.company" label="Entreprise">
                        <x-form.input name="form.company" />
                    </x-form.group>
                </div> --}}
                <!-- L'ID de l'événement est maintenant caché car récupéré depuis l'URL -->
                <input type="hidden" name="form.event_id" wire:model="form.event_id" />
            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <x-button.primary type="submit" color="blue">Enregistrer</x-button.primary>
        </div>
    </div>
</x-form.form>
