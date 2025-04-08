<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public string $nom = '';
    public string $prenom = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->prenom = Auth::user()->prenom;
        $this->nom = Auth::user()->nom;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', nom: $user->nom);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <x-form.form submit="updateProfileInformation">
        <div class="grid grid-cols-1 gap-x-6 gap-y-8">
            {{-- Nom --}}
            <div class="col-span-full">
                <x-form.group name="nom" :label="__('Nom')">
                    <x-form.input type="text" name="nom" required autofocus autocomplete="family-name" />
                </x-form.group>
            </div>

            {{-- Prénom --}}
            <div class="col-span-full">
                <x-form.group name="prenom" :label="__('Prénom')">
                    <x-form.input type="text" name="prenom" required autocomplete="given-name" />
                </x-form.group>
            </div>

            {{-- Email --}}
            <div class="col-span-full">
                <x-form.group name="email" :label="__('Email')">
                    <x-form.input type="email" name="email" required autocomplete="username" />
                </x-form.group>

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button wire:click.prevent="sendVerification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-5 flex items-center justify-start gap-4">
            <x-action-message class="me-3" on="profile-updated">
                {{ __('Enregistré.') }}
            </x-action-message>
            <x-button.primary type="submit">
                {{ __('Enregistrer') }}
            </x-button.primary>
        </div>
    </x-form.form>
</section>
