<?php

namespace App\Mail;

use App\Models\Guest;
use App\Services\QrCodeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\Storage;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Guest $guest;
    public string $qrCardPath;

    /**
     * Create a new message instance.
     */
    public function __construct(Guest $guest)
    {
        $this->guest = $guest;

        // Générer la carte QR stylisée
        $qrCodeService = app(QrCodeService::class);
        // ! $this->qrCardPath = $qrCodeService->generateStyledCardForGuest($guest);
        $this->qrCardPath = $guest->qr_code . '.png';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: 'Invitation à ' . $this->guest->event->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation',
            with: [
                'guest' => $this->guest,
                'qrCardPath' => $this->qrCardPath,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
