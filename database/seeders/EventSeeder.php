<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Enums\UserRole;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find admin users to be organizers
        $organizers = User::where('role', UserRole::ADMIN->value)->get();

        // If no admins found, use any user
        if ($organizers->isEmpty()) {
            $organizers = User::all();
        }

        // Sample events data
        $events = [
            [
                'name' => 'Conférence Annuelle',
                'description' => 'Conférence annuelle de l\'entreprise pour discuter des réalisations et des objectifs futurs.',
                'location' => 'Salle de conférence principale',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(31),
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Séminaire de formation',
                'description' => 'Formation sur les nouvelles technologies et méthodologies.',
                'location' => 'Salle de formation B',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(16),
                'organizer_id' => $organizers->random()->id,
            ],
            [
                'name' => 'Team Building',
                'description' => 'Activités de renforcement d\'équipe et de cohésion.',
                'location' => 'Parc d\'aventure',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(45),
                'organizer_id' => $organizers->random()->id,
            ],
        ];

        // Create each event
        foreach ($events as $eventData) {
            Event::create($eventData);
        }
    }
}
