<div class="flex gap-3">
    <x-button.primary type="button" color="green" wire:click="downloadCsv" icon="heroicon-o-arrow-down-tray" responsive>
        {{ __('CSV') }}
    </x-button.primary>
    <x-button.primary type="button" color="red" wire:click="downloadPdf" icon="heroicon-o-arrow-down-tray" responsive>
        {{ __('PDF') }}
    </x-button.primary>
</div>
