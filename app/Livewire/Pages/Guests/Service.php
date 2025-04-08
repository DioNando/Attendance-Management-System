<?php

namespace App\Livewire\Pages\Guests;

use App\Models\Guest;
use App\Services\QrCodeService;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class Service extends Form
{
    public ?Guest $guest = null;

    #[Validate]
    public $first_name = '';

    #[Validate]
    public $last_name = '';

    #[Validate]
    public $email = '';

    #[Validate]
    public $phone = '';

    #[Validate]
    public $company = '';

    public $qr_code = null;

    public $event_id;

    public $invitation_sent = false;

    public $invitation_sent_at = null;

    protected function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:guests,email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'event_id' => 'required|exists:events,id',
        ];
    }

    public function setGuest(Guest $guest)
    {
        $this->guest = $guest;
        $this->first_name = $guest->first_name;
        $this->last_name = $guest->last_name;
        $this->email = $guest->email;
        $this->phone = $guest->phone;
        $this->company = $guest->company;
        $this->qr_code = $guest->qr_code;
        $this->event_id = $guest->event_id;
        $this->invitation_sent = $guest->invitation_sent;
        $this->invitation_sent_at = $guest->invitation_sent_at;
    }

    public function store()
    {
        $this->validate();

        // Créer d'abord l'invité
        $guest = Guest::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'qr_code' => Str::uuid()->toString(), // Generate UUID and convert to string
            'event_id' => $this->event_id,
            'invitation_sent' => false, // Explicitly set to false
            'invitation_sent_at' => null,
        ]);

        // Ensuite, récupérer le service via le container
        $qrCodeService = app(QrCodeService::class);

        // Générer le QR code
        $qrCodeService->generateForGuest($guest);

        return $guest;
    }

    public function update()
    {
        $this->validate();

        if ($this->guest) {
            $this->guest->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'company' => $this->company,
                'event_id' => $this->event_id,
                // Don't update qr_code here
            ]);
        }
    }

    public function markInvitationSent()
    {
        $this->invitation_sent = true;
        $this->invitation_sent_at = now();

        if ($this->guest) {
            $this->guest->invitation_sent = true;
            $this->guest->invitation_sent_at = now();
            $this->guest->save();
        }
    }
}
