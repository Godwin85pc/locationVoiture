<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class VehiculeController extends Controller
{
    /**
     * Affiche la liste des véhicules
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * Formulaire de création
     * Formulaire de création
     */
    public function create()
    {
        return view('01-ajout_voiture'); // Utilise votre vue existante
    }

    /**
     * Enregistre un nouveau véhicule
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'proprietaire_id' => 'required|exists:utilisateurs,id',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:100',
            'type' => 'required|in:SUV,Berline,Utilitaire,Citadine',
            'immatriculation' => 'required|string|max:50|unique:vehicules,immatriculation',
            'prix_jour' => 'nullable|numeric',
            'prix_jour' => 'nullable|numeric',
            'statut' => 'required|in:disponible,reserve,en_location,en_attente',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
            'kilometrage' => 'nullable|integer|min:0',
            'date_ajout' => 'required|date',
        ]);

        // ✅ Calcul du prix automatique (non modifiable)
    $validated['prix_jour'] = $this->calculerPrixAutomatique($validated['type'], $validated['carburant']);

    // ✅ Upload de la photo
     if ($request->hasFile('photo')) {
          $validated['photo'] = $request->file('photo')->store('vehicules', 'public');
      }
    Vehicule::create($validated);
    session(['vehicule' => $validated]);
    return redirect()->route('02-options_extras')->with('success', 'Véhicule ajouté avec succès.');

    }

    /**
     * Affiche un véhicule
     * Affiche un véhicule
     */
    public function show($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('vehicules.show', compact('vehicule'));
    }

    /**
     * Formulaire d’édition
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
     * Met à jour un véhicule
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
            'prix_jour' => 'nullable|numeric',
            'prix_jour' => 'nullable|numeric',
            'statut' => 'required|in:disponible,reserve,en_location,maintenance',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'photo' => 'nullable|image|max:2048',
            'kilometrage' => 'nullable|integer|min:0',
            'date_ajout' => 'required|date',
        ]);

        

        // Upload photo si nouvelle
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicules', 'public');
        }
           

        // Si prix non renseigné, on le recalcule
        if (empty($validated['prix_jour'])) {
            $validated['prix_jour'] = $this->calculerPrixAutomatique($validated['type'], $validated['carburant']);
        }

        // Upload photo si nouvelle
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicules', 'public');
        }

        $vehicule->update($validated);
        return redirect()->route('vehicules.02-options_extras')->with('success', 'Véhicule modifié avec succès.');
    }

    public function resume()
{
    $vehicule = session('vehicule');

    if (!$vehicule) {
        return redirect()->route('vehicules.create')->with('error', 'Aucun véhicule en mémoire.');
    }

    return view('prix', compact('vehicule'));
}


    /**
     * Supprime un véhicule
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

    /**
     * 🔧 Fonction privée : calcule le prix selon type et carburant
     */
  private function calculerPrixAutomatique($type, $carburant)
{
    $prixType = [
        'SUV' => 25000,
        'Berline' => 20000,
        'Utilitaire' => 30000,
        'Citadine' => 15000,
    ];

    // Supplément carburant
    $supCarburant = [
        'Essence' => 0,
        'Diesel' => 2000,
        'Electrique' => 5000,
    ];

    // Calcul simple du prix
    return $prixType[$type] + $supCarburant[$carburant];
}

}
