<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use App\Models\Vehicule;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère tous les utilisateurs depuis la base de données
        $utilisateurs = Utilisateur::all();

        // Retourne la vue 'utilisateurs.index' avec la liste des utilisateurs
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Display admin view of all users with statistics.
     */
    public function adminIndex()
    {
        $utilisateurs = Utilisateur::with(['reservations'])->get();
        
        $stats = [
            'total' => $utilisateurs->count(),
            'clients' => $utilisateurs->where('role', 'client')->count(),
            'particuliers' => $utilisateurs->where('role', 'particulier')->count(),
            'admins' => $utilisateurs->where('role', 'admin')->count(),
            'actifs_ce_mois' => $utilisateurs->where('created_at', '>=', now()->startOfMonth())->count()
        ];

        return view('admin.utilisateurs.index', compact('utilisateurs', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('utilisateurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:6',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        Utilisateur::create($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email,' . $id,
            'mot_de_passe' => 'nullable|string|min:6',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $utilisateur->update($validated);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Display the admin dashboard with enhanced statistics.
     */
    public function adminDashboard()
    {
        $utilisateurs = Utilisateur::with(['reservations'])->get();
        $clients = Utilisateur::where('role', 'client')->get();
        $particuliers = Utilisateur::where('role', 'particulier')->get();
        $admins = Utilisateur::where('role', 'admin')->get();
        
        // Statistiques des véhicules
        $vehicules = Vehicule::all();
        $vehiculesDisponibles = Vehicule::where('statut', 'disponible')->count();
        $vehiculesLoues = Vehicule::where('statut', 'loue')->count();
        
        // Statistiques des réservations
        $reservations = Reservation::all();
        $reservationsEnAttente = Reservation::where('statut', 'en_attente')->count();
        $reservationsConfirmees = Reservation::where('statut', 'confirmee')->count();
        $revenuTotal = Reservation::where('statut', 'confirmee')->sum('montant_total');
        
        // Statistiques générales
        $stats = [
            'total_utilisateurs' => $utilisateurs->count(),
            'total_clients' => $clients->count(),
            'total_particuliers' => $particuliers->count(),
            'total_admins' => $admins->count(),
            'total_vehicules' => $vehicules->count(),
            'vehicules_disponibles' => $vehiculesDisponibles,
            'vehicules_loues' => $vehiculesLoues,
            'total_reservations' => $reservations->count(),
            'reservations_en_attente' => $reservationsEnAttente,
            'reservations_confirmees' => $reservationsConfirmees,
            'revenu_total' => $revenuTotal,
        ];

        return view('admin.dashboard', compact('utilisateurs', 'clients', 'particuliers', 'admins', 'vehicules', 'stats'));
    }

    /**
     * Toggle user status (activate/deactivate).
     */
    public function toggleStatus($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $utilisateur->is_active = !$utilisateur->is_active;
        $utilisateur->save();

        $status = $utilisateur->is_active ? 'activé' : 'désactivé';
        return redirect()->back()->with('success', "Utilisateur {$status} avec succès.");
    }
}
