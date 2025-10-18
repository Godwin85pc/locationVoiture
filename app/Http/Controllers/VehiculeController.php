<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    /**
     * Display a listing of vehicles (with optional search filters).
     */
    /**
 * Display a listing of vehicles (with optional search filters).
 */
public function index(Request $request)
{
    // On prépare la requête
    $query = Vehicule::with('avis')->where('disponible', 1);

    // Si le formulaire de recherche est soumis, on filtre par localisation
    if ($request->filled('lieu_recuperation')) {
        $query->where('localisation', $request->lieu_recuperation);
    }

    // On récupère les véhicules
    $vehicules = $query->get();

    // Récupérer les paramètres de recherche pour le récapitulatif
    $searchData = [
        'lieuRecup' => $request->input('lieu_recuperation'),
        'lieuRetour' => $request->input('lieu_retour'),
        'dateDepart' => $request->input('date_debut'),
        'heureDepart' => $request->input('heure_debut'),
        'dateRetour' => $request->input('date_fin'),
        'heureRetour' => $request->input('heure_fin'),
    ];

    return view('voiture2', compact('vehicules', 'searchData'));
}

    /**
     * Handle search form submission and redirect to index with filters
     */
  /**
 * Handle search form submission and redirect to index with filters
 */
public function recuperer(Request $request)
{
    $validated = $request->validate([
        'lieuRecup' => 'required|string|min:3|max:100',
        'dateDepart' => 'required|date|after_or_equal:today',
        'heureDepart' => 'required|date_format:H:i',
        'lieuRetour' => 'required|string|min:3|max:100',
        'dateRetour' => 'required|date|after:dateDepart',
        'heureRetour' => 'required|date_format:H:i',
    ]);

    // Filtrer les véhicules selon la localisation
    $vehicules = Vehicule::with('avis')
        ->where('disponible', 1)
        ->where('localisation', 'LIKE', '%' . $validated['lieuRecup'] . '%')
        ->get();

    // Préparer les données de recherche pour le récapitulatif
    $searchData = [
        'lieuRecup' => $validated['lieuRecup'],
        'lieuRetour' => $validated['lieuRetour'],
        'dateDepart' => $validated['dateDepart'],
        'heureDepart' => $validated['heureDepart'],
        'dateRetour' => $validated['dateRetour'],
        'heureRetour' => $validated['heureRetour'],
    ];

    // Afficher directement la vue au lieu de rediriger
    return view('voiture2', compact('vehicules', 'searchData'));
}

    /**
     * Show form to create a new vehicle
     */
    public function create()
    {
        return view('01-ajout_voiture');
    }

    /**
     * Store a new vehicle
     */
    public function store(Request $request)
    {
        $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'type' => 'required|in:SUV,Berline,Utilitaire,Citadine',
            'immatriculation' => 'required|string|max:50|unique:vehicules,immatriculation',
            'prix_jour' => 'required|numeric',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'kilometrage' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Vehicule::create([
            'proprietaire_id' => Auth::id(),
            'marque' => $request->marque,
            'modele' => $request->modele,
            'type' => $request->type,
            'immatriculation' => $request->immatriculation,
            'prix_jour' => $request->prix_jour,
            'statut' => 'en_attente',
            'carburant' => $request->carburant,
            'nbre_places' => $request->nbre_places,
            'localisation' => $request->localisation,
            'photo' => $request->photo,
            'kilometrage' => $request->kilometrage,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Véhicule ajouté avec succès ! Il sera visible après validation.');
    }

    /**
     * Display details of a vehicle
     */
    public function show($id)
    {
        $vehicule = Vehicule::with('avis')->findOrFail($id);
        return view('show', compact('vehicule'));
    }

    /**
     * Show form to edit a vehicle
     */
    public function edit($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres véhicules.');
        }
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Update a vehicle
     */
    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::findOrFail($id);
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:100',
            'type' => 'required|in:SUV,Berline,Utilitaire,Citadine',
            'immatriculation' => 'required|string|max:50|unique:vehicules,immatriculation,' . $id,
            'prix_jour' => 'required|numeric',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'kilometrage' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $vehicule->update($validated);

        return redirect()->route('dashboard')->with('success', 'Véhicule modifié avec succès.');
    }

    /**
     * Delete a vehicle
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403);
        }
        $vehicule->delete();

        return redirect()->route('dashboard')->with('success', 'Véhicule supprimé avec succès.');
    }

    /**
     * Admin index of all vehicles
     */
    public function adminIndex()
    {
        $vehicules = Vehicule::with('proprietaire')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $vehicules->count(),
            'en_attente' => $vehicules->where('statut', 'en_attente')->count(),
            'disponibles' => $vehicules->where('statut', 'disponible')->count(),
            'loues' => $vehicules->where('statut', 'loue')->count(),
            'rejetes' => $vehicules->where('statut', 'rejete')->count(),
        ];

        return view('admin.vehicules.index', compact('vehicules', 'stats'));
    }

    /**
     * Approve a vehicle (admin only)
     */
    public function approve($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        $vehicule->update(['statut' => 'disponible']);
        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule approuvé.');
    }

    /**
     * Reject a vehicle (admin only)
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'motif_rejet' => 'nullable|string|max:500',
        ]);

        $vehicule = Vehicule::findOrFail($id);
        $vehicule->update([
            'statut' => 'rejete',
            'motif_rejet' => $validated['motif_rejet'] ?? 'Véhicule rejeté par l\'administrateur'
        ]);

        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule rejeté.');
    }
}
