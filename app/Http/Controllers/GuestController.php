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
     * Enregistre un nouvel invité
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'event_id' => 'required|exists:events,id',
        ]);

        // Génère un QR code unique
        $validated['qr_code'] = Str::uuid();

        $guest = Guest::create($validated);

        // Génère le QR code pour cet invité si le service est disponible
        if (method_exists($this->qrCodeService, 'generateForGuest')) {
            $this->qrCodeService->generateForGuest($guest);
        }

        $event = Event::findOrFail($request->input('event_id'));

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Invité ajouté avec succès.');
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
     * Met à jour les informations d'un invité
     */
    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
        ]);

        $guest->update($validated);

        return redirect()->route('admin.events.show', $guest->event)
            ->with('success', 'Invité modifié avec succès.');
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

    /**
     * Envoie des invitations par email aux invités qui n'en ont pas encore reçu
     */
    public function sendInvitations(Event $event)
    {
        $guests = $event->guests()->where('invitation_sent', false)->get();

        foreach ($guests as $guest) {
            SendInvitationEmail::dispatch($guest);
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', 'Invitations en cours d\'envoi à ' . $guests->count() . ' invités.');
    }
}
