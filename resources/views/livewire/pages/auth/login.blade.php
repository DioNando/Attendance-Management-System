<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Providers\RouteServiceProvider;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::home(), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-form.form submit="login">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8">
            {{-- * Adresse email --}}
            <div class="col-span-full">
                <x-form.group name="form.email" :label="__('Email')">
                    <x-form.input name="form.email" required />
                </x-form.group>
            </div>
            {{-- * Mot de passe --}}
            <div class="col-span-full">
                <x-form.group name="form.password" :label="__('Mot de passe')">
                    <x-form.input type="password" name="form.password" required />
                </x-form.group>
            </div>
            {{-- * Remember me --}}
            <div class="col-span-full flex items-center gap-x-3">
                <x-form.checkbox name="form.remember" />
                <x-form.label name="form.remember" :label="__('Se souvenir de moi')" />
            </div>
        </div>
        <div class="mt-5 flex flex-col items-center gap-4 justify-end ">
            @if (Route::has('password.request'))
                <a class="self-end text-sm font-semibold text-blue-600 hover:text-blue-500"
                    href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
            <x-button.primary type="submit" class="w-full justify-center">
                {{ __('Connexion') }}
            </x-button.primary>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400"> Vous n'avez pas de compte ? <a
                    class="font-semibold text-blue-600 hover:text-blue-500" href="{{ route('register') }}"
                    wire:navigate>
                    {{ __('Créer un compte') }}
                </a></p>
        </div>
    </x-form.form>
</div>
