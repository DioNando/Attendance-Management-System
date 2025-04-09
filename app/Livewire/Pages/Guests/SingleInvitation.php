<?php

namespace App\Livewire\Pages\Guests;

use App\Jobs\SendInvitationEmail;
use App\Models\Guest;
use Livewire\Component;

class SingleInvitation extends Component
{
    public Guest $guest;

    public function mount(Guest $guest)
    {
        $this->guest = $guest;
    }

    public function sendInvitation()
    {
        SendInvitationEmail::dispatch($this->guest);

        // Mettre à jour le statut d'envoi
        $this->guest->invitation_sent = true;
        $this->guest->invitation_sent_at = now();
        $this->guest->save();

        session()->flash('success', "Invitation envoyée à {$this->guest->first_name} {$this->guest->last_name}.");
        $this->dispatch('invitationSent', $this->guest->id);
    }

    public function render()
    {
        return view('livewire.pages.guests.single-invitation');
    }
}
