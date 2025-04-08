<x-form.form submit="store">
    <div class="mt-5 md:max-w-md bg-white dark:bg-gray-900 ring-1 ring-gray-200 dark:ring-gray-700 rounded-lg p-8">
        <h3 class="text-xl font-medium mb-3">Ajout d'un nouvel evenement</h3>
        <div class="grid grid-cols-1 border-b border-gray-900/10 dark:border-gray-700 pb-12">
            <div class="flex flex-col gap-x-6 gap-y-8">
                <div class="sm:col-span-full">
                    <x-form.group name="form.name" label="Nom" required>
                        <x-form.input name="form.name" :live="true" required />
                    </x-form.group>
                </div>
                <div class="col-span-full">
                    <x-form.group name="form.description" label="Description">
                        <x-form.textarea name="form.description" />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.location" label="Localisation">
                        <x-form.input name="form.location" />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.start_date" label="Début">
                        <x-form.input type="date" name="form.start_date" />
                    </x-form.group>
                </div>
                <div class="sm:col-span-full">
                    <x-form.group name="form.end_date" label="Fin">
                        <x-form.input type="date" name="form.end_date" />
                    </x-form.group>
                </div>

            </div>
        </div>
        <div class="mt-6 flex items-center justify-end gap-x-6">
            <x-button.primary type="submit" color="blue">Enregistrer</x-button.primary>
        </div>
    </div>
</x-form.form>
