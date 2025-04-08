<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un utilisateur pour chaque rôle
        foreach (UserRole::all() as $role) {
            User::factory()->create([
                'last_name' => 'User ' . $role->value,
                'first_name' => ucfirst($role->value),
                'email' => $role->value . '@example.com',
                'role' => $role->value,
            ]);
        }

        $this->call([
            EventSeeder::class,
        ]);
    }
}
