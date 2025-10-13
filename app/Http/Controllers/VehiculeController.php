<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('01-ajout_voiture'); // Utilise votre vue existante
    }

    /**
     * Store a newly created resource in storage.
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
            'statut' => 'en_attente', // Statut en attente de validation admin
            'carburant' => $request->carburant,
            'nbre_places' => $request->nbre_places,
            'localisation' => $request->localisation,
            'photo' => $request->photo,
            'kilometrage' => $request->kilometrage,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Véhicule ajouté avec succès ! Il sera visible après validation par un administrateur.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('vehicules.show', compact('vehicule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        
        // Vérifier que l'utilisateur est le propriétaire
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres véhicules.');
        }
        
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::findOrFail($id);

        // Vérifier que l'utilisateur est le propriétaire
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez modifier que vos propres véhicules.');
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
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        
        // Vérifier que l'utilisateur est le propriétaire
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous ne pouvez supprimer que vos propres véhicules.');
        }
        
        $vehicule->delete();

        return redirect()->route('dashboard')->with('success', 'Véhicule supprimé avec succès.');
    }

    /**
     * Display admin view of all vehicles.
     */
    public function adminIndex()
    {
        $vehicules = Vehicule::with(['proprietaire'])->orderBy('created_at', 'desc')->get();
        
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
     * Approve a vehicle (admin only).
     */
    public function approve($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        $vehicule->update(['statut' => 'disponible']);

        return redirect()->route('admin.vehicules.index')->with('success', 'Véhicule approuvé avec succès.');
    }

    /**
     * Reject a vehicle (admin only).
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
