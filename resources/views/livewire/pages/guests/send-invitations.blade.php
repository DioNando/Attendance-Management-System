<div class="flex gap-3">
    <x-button.primary type="button" color="blue" wire:click="sendInvitations" icon="heroicon-o-paper-airplane" responsive>
        {{ __('Envoyer les invitations') }}
    </x-button.primary>
    <x-button.primary type="button" color="gray" wire:click="resendAllInvitations" icon="heroicon-o-arrow-path" responsive>
        {{ __('Renvoyer toutes les invitations') }}
    </x-button.primary>
</div>
