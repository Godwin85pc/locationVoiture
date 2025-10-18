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
        $utilisateurs = Utilisateur::orderBy('created_at', 'desc')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.utilisateurs.create');
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
            'mot_de_passe' => 'required|string|min:6|confirmed',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);

        Utilisateur::create($validated);

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
  
    public function show($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        $reservations = Reservation::where('client_id', $id)->orderBy('date_reservation', 'desc')->get();
        $totalRevenus = $reservations->where('statut', 'confirmee')->sum('montant_total');
        
        return view('admin.utilisateurs.show', compact('utilisateur', 'reservations', 'totalRevenus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);
        return view('admin.utilisateurs.edit', compact('utilisateur'));
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
            'mot_de_passe' => 'nullable|string|min:6|confirmed',
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,client,particulier',
        ]);

        if (!empty($validated['mot_de_passe'])) {
            $validated['mot_de_passe'] = Hash::make($validated['mot_de_passe']);
        } else {
            unset($validated['mot_de_passe']);
        }

        $utilisateur->update($validated);

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('admin.utilisateurs.index')->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $utilisateur = Utilisateur::findOrFail($id);
        
        // Vérifier s'il y a des véhicules ou réservations liés
        if ($utilisateur->vehicules()->count() > 0) {
            return redirect()->route('admin.utilisateurs.index')->with('error', 'Impossible de supprimer cet utilisateur car il possède des véhicules.');
        }

        $utilisateur->delete();

        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Display the admin dashboard.
     */
    public function adminDashboard()
    {
        $utilisateurs = Utilisateur::orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('utilisateurs'));
    }

    /**
     * Display statistics page.
     */
    public function statistics()
    {
        $stats = [
            'utilisateurs' => [
                'total' => Utilisateur::count(),
                'clients' => Utilisateur::where('role', 'client')->count(),
                'particuliers' => Utilisateur::where('role', 'particulier')->count(),
                'admins' => Utilisateur::where('role', 'admin')->count(),
                'nouveaux_ce_mois' => Utilisateur::whereMonth('created_at', now()->month)->count(),
            ],
            'vehicules' => [
                'total' => Vehicule::count(),
                'disponibles' => Vehicule::where('statut', 'disponible')->count(),
                'en_location' => Vehicule::where('statut', 'loue')->count(),
                'en_attente' => Vehicule::where('statut', 'en_attente')->count(),
            ],
            'reservations' => [
                'total' => Reservation::count(),
                'confirmees' => Reservation::where('statut', 'confirmee')->count(),
                'en_attente' => Reservation::where('statut', 'en_attente')->count(),
                'annulees' => Reservation::where('statut', 'annulee')->count(),
                'ce_mois' => Reservation::whereMonth('date_reservation', now()->month)->count(),
            ],
            'finances' => [
                'revenus_total' => Reservation::where('statut', 'confirmee')->sum('montant_total'),
                'revenus_ce_mois' => Reservation::where('statut', 'confirmee')
                    ->whereMonth('date_reservation', now()->month)->sum('montant_total'),
                'revenus_moyenne' => Reservation::where('statut', 'confirmee')->avg('montant_total'),
            ]
        ];

        return view('admin.statistiques', compact('stats'));
    }
}
