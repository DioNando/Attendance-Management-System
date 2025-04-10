<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Attendance;
use App\Models\Event;
use App\Services\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScanController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    protected $qrCodeService;

    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
        $this->middleware('auth');
    }

    /**
     * Affiche l'interface de scan pour un événement
     */
    public function showScanInterface(Event $event)
    {
        // $this->authorize('scan', $event);

        return view('pages.scan.index', compact('event'));
    }

    /**
     * Traite les données du QR code scanné
     */
    public function processQrCode(Request $request, Event $event)
    {
        // $this->authorize('scan', $event);

        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $result = $this->qrCodeService->verifyAndRegisterAttendance(
            $request->qr_code,
            $event->id,
            Auth::id()
        );

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['status'] === 'success') {
            return redirect()->back()->with('success', $result['message']);
        }
        if ($result['status'] === 'warning') {
            return redirect()->back()->with('warning', $result['message']);
        } else {
            return redirect()->back()->with('error', $result['message']);
        }
    }

    /**
     * Affiche les statistiques de scan en temps réel
     */
    public function scanStats(Event $event)
    {
        // $this->authorize('viewStats', $event);

        $stats = $this->qrCodeService->getQrCodeStats($event);
        $recentArrivals = $event->attendances()
            ->with('guest')
            ->latest()
            ->take(10)
            ->get();

        return view('scan.stats', compact('event', 'stats', 'recentArrivals'));
    }
}
