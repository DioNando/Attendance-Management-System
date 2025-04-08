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
     * Importe des invités à partir d'un fichier CSV
     */
    public function import(Request $request, Event $event)
    {
        $request->validate([
            'guests_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('guests_file');
        $path = $file->getRealPath();

        $guestsData = array_map('str_getcsv', file($path));
        $headers = array_shift($guestsData);

        $guestsAdded = 0;

        foreach ($guestsData as $guestData) {
            $guestData = array_combine($headers, $guestData);

            $guest = $event->guests()->create([
                'first_name' => $guestData['first_name'],
                'last_name' => $guestData['last_name'],
                'email' => $guestData['email'],
                'phone' => $guestData['phone'] ?? null,
                'company' => $guestData['company'] ?? null,
                'qr_code' => Str::uuid(),
            ]);

            // Génère le QR code pour cet invité si le service est disponible
            if (method_exists($this->qrCodeService, 'generateForGuest')) {
                $this->qrCodeService->generateForGuest($guest);
            }

            $guestsAdded++;
        }

        return redirect()->route('admin.events.show', $event)
            ->with('success', "$guestsAdded invités importés avec succès.");
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

    /**
     * Exporte la liste des invités d'un événement au format CSV
     *
     * @param Event $event
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Event $event)
    {
        $fileName = 'invites_' . $event->slug . '_' . date('Y-m-d') . '.csv';
        $guests = $event->guests()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $columns = ['first_name', 'last_name', 'email', 'phone', 'company', 'invitation_sent'];

        $callback = function() use($guests, $columns) {
            $file = fopen('php://output', 'w');

            // Ajoute la ligne d'en-tête
            fputcsv($file, $columns);

            // Ajoute les données
            foreach ($guests as $guest) {
                $row = [];
                foreach ($columns as $column) {
                    if ($column == 'invitation_sent') {
                        $row[] = $guest->$column ? 'Oui' : 'Non';
                    } else {
                        $row[] = $guest->$column;
                    }
                }
                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
