<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use App\Jobs\SendInvitationEmail;
use Illuminate\Support\Str;

class GuestController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    /**
     * Affiche la liste des invités pour un événement
     */
    public function index(Event $event)
    {
        $guests = $event->guests()->paginate(15);
        return view('pages.guests.index', compact('event', 'guests'));
    }

    /**
     * Affiche le formulaire de création d'un invité
     */
    public function create(Request $request)
    {
        // $event = Event::findOrFail($request->query('event_id', 1));
        return view('pages.guests.create');
    }

    /**
     * Affiche le formulaire de modification d'un invité
     */
    public function edit(Guest $guest)
    {
        $event = $guest->event;
        return view('pages.guests.edit', compact('guest', 'event'));
    }


    /**
     * Supprime un invité
     */
    public function destroy(Guest $guest)
    {
        $event = $guest->event;
        $guest->delete();

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Invité supprimé avec succès.');
    }
}
