<div class="flex items-center">
    @if($guest->invitation_sent)
        <button
            wire:click="sendInvitation"
            class="text-blue-700 dark:text-blue-300 hover:text-blue-500 flex items-center"
            title="Renvoyer l'invitation">
            <x-heroicon-o-arrow-path class="size-4 mr-1" />
            Renvoyer
        </button>
    @else
        <button
            wire:click="sendInvitation"
            class="text-green-700 dark:text-green-300 hover:text-green-500 flex items-center"
            title="Envoyer l'invitation">
            <x-heroicon-o-paper-airplane class="size-4 mr-1" />
            Envoyer
        </button>
    @endif
</div>
