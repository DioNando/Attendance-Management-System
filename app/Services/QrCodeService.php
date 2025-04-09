<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\Facades\Image;

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

    /**
     * Génère une carte stylisée contenant le QR code et le titre de l'événement
     *
     * @param Guest $guest
     * @return string Chemin vers l'image générée
     */
    // ? public function generateStyledCardForGuest(Guest $guest): string
    // {
    //     $path = $guest->qr_code . '.png';
    //     return $path;
    // }
    public function generateStyledCardForGuest(Guest $guest): string
    {
        // Générer d'abord le QR code
        $data = [
            'id' => $guest->id,
            'event_id' => $guest->event_id,
            'qr_code' => $guest->qr_code,
        ];

        $qrCode = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate(json_encode($data));

        // Créer un fichier temporaire pour le QR code
        $tempQrPath = storage_path('app/temp_' . $guest->qr_code . '.png');
        file_put_contents($tempQrPath, $qrCode);

        // Créer une image avec Intervention Image
        $canvas = Image::canvas(800, 400, '#ffffff');

        // Charger le QR code dans l'image
        $qrImage = Image::make($tempQrPath);
        $canvas->insert($qrImage, 'left', 50, 50);

        // Ajouter le nom de l'événement
        $canvas->text($guest->event->name, 400, 120, function($font) {
            $font->file(public_path('fonts/OpenSans-Bold.ttf'));
            $font->size(36);
            $font->color('#3498db');
            $font->align('left');
            $font->valign('middle');
        });

        // Ajouter le nom du guest
        $canvas->text("{$guest->first_name} {$guest->last_name}", 400, 200, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(24);
            $font->color('#2c3e50');
            $font->align('left');
            $font->valign('middle');
        });

        // Ajouter les informations de base de l'événement (date)
        $dateText = $guest->event->end_date && $guest->event->start_date->format('Y-m-d') != $guest->event->end_date->format('Y-m-d')
            ? "Du {$guest->event->start_date->format('d/m/Y')} au {$guest->event->end_date->format('d/m/Y')}"
            : "Le {$guest->event->start_date->format('d/m/Y')}";

        $canvas->text($dateText, 400, 250, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(18);
            $font->color('#7f8c8d');
            $font->align('left');
            $font->valign('middle');
        });

        // Ajouter le code d'invitation
        $canvas->text("Code: {$guest->qr_code}", 400, 300, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(18);
            $font->color('#7f8c8d');
            $font->align('left');
            $font->valign('middle');
        });

        // Enregistrer l'image finale
        $path = 'qr-cards/' . $guest->qr_code . '.png';
        Storage::makeDirectory('public/qr-cards');
        $canvas->save(storage_path('app/public/' . $path));

        // Supprimer le fichier temporaire
        @unlink($tempQrPath);

        return $path;
    }
}
