<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <x-form.form submit="updatePassword">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8">
            {{-- Current Password --}}
            <div class="col-span-full">
                <x-form.group name="current_password" :label="__('Mot de passe actuel')">
                    <x-form.input type="password" name="current_password" required />
                </x-form.group>
            </div>

            {{-- New Password --}}
            <div class="col-span-full">
                <x-form.group name="password" :label="__('Nouveau mot de passe')">
                    <x-form.input type="password" name="password" required />
                </x-form.group>
            </div>

            {{-- Confirm Password --}}
            <div class="col-span-full">
                <x-form.group name="password_confirmation" :label="__('Confirmer le mot de passe')">
                    <x-form.input type="password" name="password_confirmation" required />
                </x-form.group>
            </div>
        </div>

        <div class="mt-5 flex items-center justify-start gap-4">
            <x-action-message class="me-3" on="password-updated">
                {{ __('Enregistré.') }}
            </x-action-message>
            <x-button.primary type="submit">
                {{ __('Enregistrer') }}
            </x-button.primary>
        </div>
    </x-form.form>
</section>
