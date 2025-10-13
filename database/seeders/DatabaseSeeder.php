<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateur;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed optionnel d'un utilisateur de test (client)
        if (!Utilisateur::where('email', 'client@example.com')->exists()) {
            Utilisateur::create([
                'nom' => 'Client',
                'prenom' => 'Demo',
                'email' => 'client@example.com',
                'mot_de_passe' => \Illuminate\Support\Facades\Hash::make('password'),
                'telephone' => '0600000000',
                'role' => 'client',
            ]);
        }

        // Appel du seeder Admin
        $this->call([
            AdminSeeder::class,
        ]);
    }
}
