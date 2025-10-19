<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\Vehicule;
use App\Models\OffreVehicule;
use App\Models\Reservation;
use App\Mail\VehiculeValideMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
            'total_reservations' => Reservation::count(),
            'total_offres' => OffreVehicule::whereNotNull('vehicule_id')->count(),
            'nouveaux_utilisateurs_mois' => Utilisateur::whereMonth('created_at', Carbon::now()->month)->count(),
            'reservations_actives' => Reservation::whereIn('statut', ['en_attente', 'confirmee'])->count(),
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

        // Véhicules en attente de validation
        $vehicules_en_attente = Vehicule::where('statut', 'en_attente')
            ->with('proprietaire')
            ->latest()
            ->take(10)
            ->get();

        // Dernières réservations
        $dernieres_reservations = Reservation::with(['vehicule', 'utilisateur'])
            ->latest()
            ->take(10)
            ->get();

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
        $reservations = Reservation::with(['vehicule', 'utilisateur'])
            ->latest()
            ->paginate(15);
        return view('admin.reservations', compact('reservations'));
    }

    /**
     * Page de notification des véhicules en attente
     */
    public function notificationVehicule()
    {
        // Récupérer tous les véhicules dont le statut est 'en_attente'
        $vehicules = Vehicule::where('statut', 'en_attente')
            ->with('proprietaire')
            ->latest()
            ->get();

        return view('admin.notification', compact('vehicules'));
    }

    /**
     * Valider un véhicule et envoyer un mail au loueur
     */
    public function validerVehicule($id)
    {
        $vehicule = Vehicule::findOrFail($id);

        // On met à jour le statut (disponible au lieu de valide pour cohérence)
        $vehicule->statut = 'disponible';
        $vehicule->save();

        // Envoi du mail au propriétaire
        try {
            Mail::to($vehicule->proprietaire->email)->send(new VehiculeValideMail($vehicule));
            $message = 'Le véhicule a été validé et un mail a été envoyé au loueur.';
        } catch (\Exception $e) {
            $message = 'Le véhicule a été validé mais l\'envoi du mail a échoué.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Rejeter un véhicule
     */
    public function rejeterVehicule(Request $request, $id)
    {
        $request->validate([
            'motif_rejet' => 'nullable|string|max:500'
        ]);

        $vehicule = Vehicule::findOrFail($id);
        $vehicule->statut = 'rejete';
        $vehicule->motif_rejet = $request->motif_rejet ?? 'Véhicule rejeté par l\'administrateur';
        $vehicule->save();

        return redirect()->back()->with('success', 'Le véhicule a été rejeté.');
    }
}
