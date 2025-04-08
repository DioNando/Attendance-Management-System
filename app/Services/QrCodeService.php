<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    public function generateForGuest(Guest $guest): string
    {
        $data = [
            'id' => $guest->id,
            'event_id' => $guest->event_id,
            'qr_code' => $guest->qr_code,
        ];

        $qrCode = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate(json_encode($data));
        $path = 'qr-codes/' . $guest->qr_code . '.png';
        Storage::put('public/' . $path, $qrCode);

        return $path;
    }

    public function validateQrCode(string $qrCodeData): ?Guest
    {
        $data = json_decode($qrCodeData, true);

        if (!$data || !isset($data['qr_code'])) {
            return null;
        }

        return Guest::where('qr_code', $data['qr_code'])->first();
    }
}
