<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-form.form submit="sendPasswordResetLink">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8">
            <!-- Email Address -->
            <div class="col-span-full">
                <x-form.group name="email" :label="__('Email')">
                    <x-form.input name="email" wire:model="email" required />
                </x-form.group>
            </div>
        </div>
        <div class="mt-5 flex flex-col items-center gap-4 justify-end">
            <x-button.primary type="submit" class="w-full justify-center">
                {{ __('Envoyer le lien de réinitialisation') }}
            </x-button.primary>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Vous vous souvenez de votre mot de passe ?') }}
                <a class="font-semibold text-blue-600 hover:text-blue-500"
                    href="{{ route('login') }}" wire:navigate>
                    {{ __('Connexion') }}
                </a>
            </p>
        </div>
    </x-form.form>
</div>
