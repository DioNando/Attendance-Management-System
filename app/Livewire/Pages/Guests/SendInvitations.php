<?php

namespace App\Livewire\Pages\Guests;

use App\Jobs\SendInvitationEmail;
use App\Models\Event;
use App\Models\Guest;
use Livewire\Component;

class SendInvitations extends Component
{
    public Event $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function sendInvitations()
    {
        // Récupérer tous les invités pour cet événement qui n'ont pas encore reçu d'invitation
        $guests = $this->event->guests()->where('invitation_sent', false)->get();
        $guestCount = $guests->count();

        if ($guestCount === 0) {
            session()->flash('info', 'Tous les invités ont déjà reçu une invitation.');
            return;
        }

        // Envoyer un email à chaque invité qui n'a pas encore reçu d'invitation
        foreach ($guests as $guest) {
            SendInvitationEmail::dispatch($guest);

            // Marquer l'invité comme ayant reçu l'invitation
            $guest->invitation_sent = true;
            $guest->invitation_sent_at = now();
            $guest->save();
        }

        session()->flash('success', "Invitations en cours d'envoi à {$guestCount} invités.");
        $this->dispatch('invitationsSent'); // Émettre un événement pour rafraîchir la liste des invités
    }

    // Méthode pour renvoyer toutes les invitations, même à ceux qui l'ont déjà reçue
    public function resendAllInvitations()
    {
        // Récupérer tous les invités pour cet événement
        $guests = $this->event->guests;
        $guestCount = $guests->count();

        if ($guestCount === 0) {
            session()->flash('error', 'Aucun invité à contacter.');
            return;
        }

        // Envoyer un email à chaque invité
        foreach ($guests as $guest) {
            SendInvitationEmail::dispatch($guest);

            // Mettre à jour la date d'envoi
            $guest->invitation_sent = true;
            $guest->invitation_sent_at = now();
            $guest->save();
        }

        session()->flash('success', "Renvoi des invitations en cours à {$guestCount} invités.");
        $this->dispatch('invitationsSent'); // Émettre un événement pour rafraîchir la liste des invités
    }

    // Méthode pour envoyer une invitation à un invité spécifique
    public function sendInvitationToGuest($guestId)
    {
        $guest = Guest::findOrFail($guestId);

        SendInvitationEmail::dispatch($guest);

        // Mettre à jour le statut d'envoi
        $guest->invitation_sent = true;
        $guest->invitation_sent_at = now();
        $guest->save();

        session()->flash('success', "Invitation envoyée à {$guest->first_name} {$guest->last_name}.");
        $this->dispatch('invitationSent', $guestId); // Émettre un événement pour mettre à jour le statut de cet invité
    }

    public function render()
    {
        return view('livewire.pages.guests.send-invitations');
    }
}
