<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!Utilisateur::where('email', 'client@example.com')->exists()) {
            Utilisateur::create([
                'nom' => 'Client',
                'prenom' => 'Demo',
                'email' => 'client@example.com',
                'password' => Hash::make('password'),
                'telephone' => '0600000000',
                'role' => 'client',
            ]);
        }

        $this->call([
            AdminSeeder::class,
        ]);
    }
}
