<x-app-layout>
    <x-slot name="header">
        <x-label.page-title label="Profile" />
    </x-slot>

    <div class="space-y-6">
        <x-description.card title="Informations du profil"
            description="Mettez à jour les informations de votre profil et votre adresse e-mail.">
            <livewire:profile.update-profile-information-form />
        </x-description.card>
        <x-description.card title="Modifier le mot de passe"
            description="Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.">
            <livewire:profile.update-password-form />
        </x-description.card>
        <x-description.card title="Supprimer le compte" :defaultOpen="true"
            description="Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.">
            <livewire:profile.delete-user-form />
        </x-description.card>
    </div>
</x-app-layout>
