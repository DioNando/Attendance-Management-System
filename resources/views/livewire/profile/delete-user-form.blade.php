<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <x-button.primary type="button" x-data="" color="red"
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Supprimer compte') }}</x-button.primary>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <x-form.form submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
            </p>

            <div class="mt-6">
                <x-form.group name="password" :label="__('Mot de passe')">
                    <x-form.input type="password" name="password" required />
                </x-form.group>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-button.primary type="button" color="gray" x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-button.primary>
                <x-button.primary type="submit" color="red">
                    {{ __('Supprimer compte') }}
                </x-button.primary>
            </div>
        </x-form.form>
    </x-modal>
</section>
