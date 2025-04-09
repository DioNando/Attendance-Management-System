<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Event;
use App\Models\Guest;
use App\Services\QrCodeService;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Import extends Component
{
    use WithFileUploads;

    public $event;
    public $guests = [];
    public $guestsFile;
    public $importedCount = 0;
    public $isImporting = false;
    public $importComplete = false;

    protected $qrCodeService;

    protected $rules = [
        'guestsFile' => 'required|file|mimes:csv,txt|max:2048',
    ];

    public function boot(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function import()
    {
        $this->validate();
        $this->isImporting = true;
        $this->importComplete = false;

        $path = $this->guestsFile->getRealPath();
        $guestsData = array_map('str_getcsv', file($path));
        $headers = array_shift($guestsData);

        $this->importedCount = 0;

        foreach ($guestsData as $guestData) {
            $guestData = array_combine($headers, $guestData);

            $guest = $this->event->guests()->create([
                'first_name' => $guestData['first_name'],
                'last_name' => $guestData['last_name'],
                'email' => $guestData['email'],
                'phone' => $guestData['phone'] ?? null,
                // 'company' => $guestData['company'] ?? null,
                'qr_code' => Str::uuid(),
            ]);

            // Génère le QR code pour cet invité si le service est disponible
            // if (method_exists($this->qrCodeService, 'generateForGuest')) {
            //     $this->qrCodeService->generateForGuest($guest);
            // }

            $this->importedCount++;
        }

        $this->isImporting = false;
        $this->importComplete = true;
        $this->guestsFile = null;

        session()->flash('message', "{$this->importedCount} invités importés avec succès.");
        $this->dispatch('guestImported');
    }

    public function render()
    {
        return view('livewire.pages.guests.import');
    }
}
