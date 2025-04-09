<?php

namespace App\Jobs;

use App\Mail\ContactGuest;
use App\Models\Guest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationEmail;

class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // protected $guest;

    /**
     * Create a new job instance.
     */
    // public function __construct(Guest $guest)
    // {
    //     $this->guest = $guest;
    // }
    public function __construct(protected Guest $guest)
    {
        // $this->guest = $guest;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Créer et envoyer l'email d'invitation avec le QR code
        Mail::to($this->guest->email)
            ->send(new InvitationEmail($this->guest));
    }
}
