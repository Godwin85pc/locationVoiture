<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;

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
     */
    public function create()
    {
        return view('vehicules.create');
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
            'statut' => 'required|in:disponible,reserve,en_location,maintenance',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
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

    return redirect()->route('vehicules.index')->with('success', 'Véhicule ajouté avec succès.');

    }

    /**
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
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Met à jour un véhicule
     */
    public function update(Request $request, $id)
    {
        $vehicule = Vehicule::findOrFail($id);

        $validated = $request->validate([
            'proprietaire_id' => 'required|exists:utilisateurs,id',
            'marque' => 'required|string|max:100',
            'modele' => 'required|string|max:100',
            'type' => 'required|in:SUV,Berline,Utilitaire,Citadine',
            'immatriculation' => 'required|string|max:50|unique:vehicules,immatriculation,' . $id,
            'prix_jour' => 'nullable|numeric',
            'statut' => 'required|in:disponible,reserve,en_location,maintenance',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'kilometrage' => 'nullable|integer|min:0',
            'date_ajout' => 'required|date',
        ]);

        // Si prix non renseigné, on le recalcule
        if (empty($validated['prix_jour'])) {
            $validated['prix_jour'] = $this->calculerPrixAutomatique($validated['type'], $validated['carburant']);
        }

        // Upload photo si nouvelle
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('vehicules', 'public');
        }

        $vehicule->update($validated);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule modifié avec succès.');
    }

    /**
     * Supprime un véhicule
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        $vehicule->delete();

        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
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