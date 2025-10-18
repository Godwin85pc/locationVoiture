<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crée un admin seulement s'il n'existe pas déjà
        if (!Utilisateur::where('email', 'admin@example.com')->exists()) {
            Utilisateur::create([
                'nom' => 'Admin',
                'prenom' => 'Super',
                'email' => 'admin@example.com',
                'mot_de_passe' => Hash::make('password'), // A changer en production
                'telephone' => '0102030405',
                'role' => 'admin',
            ]);
        }
    }
}
