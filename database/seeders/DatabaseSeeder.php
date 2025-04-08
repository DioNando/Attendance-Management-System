<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Créer un utilisateur admin par défaut
        User::factory()->create([
            'nom' => 'Test User',
            'prenom' => 'Test',
            'email' => 'test@example.com',
            'role' => 'admin',
            'statut' => fake()->boolean(),
        ]);

        // Créer un utilisateur pour chaque rôle
        foreach (UserRole::all() as $role) {
            User::factory()->create([
                'nom' => 'User ' . $role->value,
                'prenom' => ucfirst($role->value),
                'email' => $role->value . '@example.com',
                'role' => $role->value,
                'statut' => true,
            ]);
        }
    }
}
