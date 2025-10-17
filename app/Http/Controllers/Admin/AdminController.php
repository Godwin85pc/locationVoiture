<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Vehicule;
use App\Models\OffreVehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Afficher le dashboard administrateur
     */
    public function dashboard()
    {
        // Statistiques générales
        $stats = [
            'total_utilisateurs' => Utilisateur::count(),
            'total_vehicules' => Vehicule::count(),
            'total_reservations' => 0, // Temporairement désactivé - module en développement
            'total_offres' => OffreVehicule::whereNotNull('vehicule_id')->count(),
            'nouveaux_utilisateurs_mois' => Utilisateur::whereMonth('created_at', Carbon::now()->month)->count(),
            'reservations_actives' => 0, // Temporairement désactivé - module en développement
        ];

        // Utilisateurs par rôle
        $utilisateurs_par_role = Utilisateur::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role')
            ->toArray();

        // Derniers utilisateurs inscrits
        $derniers_utilisateurs = Utilisateur::latest()
            ->take(5)
            ->get();

        // Véhicules en attente de validation (nous ajouterons ce statut plus tard)
        $vehicules_en_attente = collect(); // Temporairement vide - fonctionnalité en développement

        // Dernières réservations - temporairement désactivé
        $dernieres_reservations = collect(); // Temporairement vide - module en développement

        // Véhicules par statut
        $vehicules_par_statut = Vehicule::select('statut', DB::raw('count(*) as total'))
            ->groupBy('statut')
            ->pluck('total', 'statut')
            ->toArray();

        return view('admin.dashboard', compact(
            'stats',
            'utilisateurs_par_role',
            'derniers_utilisateurs',
            'vehicules_en_attente',
            'dernieres_reservations',
            'vehicules_par_statut'
        ));
    }

    /**
     * Gérer les utilisateurs
     */
    public function utilisateurs()
    {
        $utilisateurs = Utilisateur::latest()->paginate(15);
        return view('admin.utilisateurs', compact('utilisateurs'));
    }

    /**
     * Gérer les véhicules
     */
    public function vehicules()
    {
        $vehicules = Vehicule::with(['proprietaire'])->latest()->paginate(15);
        return view('admin.vehicules', compact('vehicules'));
    }

    /**
     * Gérer les réservations
     */
    public function reservations()
    {
        // Temporairement désactivé - module en développement par une camarade
        $reservations = collect();
        return view('admin.reservations', compact('reservations'));
    }
}
