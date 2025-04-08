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
        // Créer un utilisateur admin par défaut
        User::factory()->create([
            'last_name' => 'Test User',
            'first_name' => 'Test',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        // Créer un utilisateur pour chaque rôle
        foreach (UserRole::all() as $role) {
            User::factory()->create([
            'last_name' => 'User ' . $role->value,
            'first_name' => ucfirst($role->value),
            'email' => $role->value . '@example.com',
            'role' => $role->value,
            ]);
        }
    }
}
