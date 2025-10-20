<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un utilisateur de test s'il n'existe pas déjà
        if (!Utilisateur::where('email', 'test@test.com')->exists()) {
            $user = new Utilisateur();
            $user->nom = 'Test';
            $user->prenom = 'User';
            $user->email = 'test@test.com';
            $user->telephone = '1234567890';
            $user->password = Hash::make('password');
            $user->role = 'client';
            $user->email_verified_at = now();
            $user->save();
            
            echo "Utilisateur test créé:\n";
            echo "Email: test@test.com\n";
            echo "Password: password\n";
        } else {
            echo "Utilisateur test existe déjà\n";
        }
    }
}
