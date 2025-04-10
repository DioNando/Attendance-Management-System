<?php

namespace App\Livewire\Pages\Guests;

use Livewire\Component;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Auth;

class Scan extends Component
{
    public $event;
    public $qr_code;
    public $result = null;
    public $guest = null;
    public $show_result = false;

    public function mount($event)
    {
        $this->event = $event;
    }

    public function processQrCode($qr_code = null)
    {
        if ($qr_code) {
            $this->qr_code = $qr_code;
        }

        if (empty($this->qr_code)) {
            return;
        }

        $qrCodeService = app(QrCodeService::class);
        $result = $qrCodeService->verifyAndRegisterAttendance(
            $this->qr_code,
            $this->event->id,
            Auth::id()
        );

        $this->result = $result;
        $this->guest = $result['guest'] ?? null;
        $this->show_result = true;

        // Dispatcher un événement pour mettre à jour la liste des scans récents
        if ($result['status'] === 'success') {
            $this->dispatch('scanProcessed');
        }

        // Réinitialiser le champ après traitement pour les entrées manuelles
        $this->qr_code = '';
    }

    public function resetResult()
    {
        $this->result = null;
        $this->guest = null;
        $this->show_result = false;
    }

    public function render()
    {
        return view('livewire.pages.guests.scan');
    }
}
