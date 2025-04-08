<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Attendance;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScanController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function index()
    {
        return view('scan.index');
    }

    public function verify(Request $request)
    {
        $qrData = $request->input('qr_data');
        $guest = $this->qrCodeService->validateQrCode($qrData);

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'QR code invalide'
            ], 400);
        }

        // Vérifier si déjà enregistré
        $attendance = Attendance::where('guest_id', $guest->id)
            ->where('event_id', $guest->event_id)
            ->first();

        if ($attendance && $attendance->checked_in_at) {
            return response()->json([
                'success' => false,
                'message' => 'Invité déjà enregistré',
                'guest' => $guest,
                'checked_in_at' => $attendance->checked_in_at
            ]);
        }

        // Créer ou mettre à jour l'enregistrement de présence
        if (!$attendance) {
            $attendance = new Attendance([
                'guest_id' => $guest->id,
                'event_id' => $guest->event_id,
            ]);
        }

        $attendance->checked_in_at = now();
        $attendance->checked_in_by = Auth::id();
        $attendance->status = 'checked-in';
        $attendance->save();

        return response()->json([
            'success' => true,
            'message' => 'Invité enregistré avec succès',
            'guest' => $guest,
            'checked_in_at' => $attendance->checked_in_at
        ]);
    }
}
