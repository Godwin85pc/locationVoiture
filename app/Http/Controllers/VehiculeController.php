<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Avis;



class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicules = Vehicule::all();
        return view('voiture2', ['vehicules' => $vehicules]);
    }

     public function recuperer(Request $request)
    {
        $post=$request->validate([
            'lieuRecup' => 'required|string|min:3|max:100',
            'dateDepart' => 'required|date|after_or_equal:today',
            'heureDepart' => 'required|date_format:H:i',
            'lieuRetour' => 'required|string|min:3|max:100',
            'dateRetour' => 'required|date|after:dateDepart',
            'heureRetour' => 'required|date_format:H:i',
            'ageCheck' => 'nullable|boolean',
        
        ]);
        $vehicules = Vehicule::all();
        return view('voiture2', ['vehicules' => $vehicules,'request'=>$post]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vehicules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function storeAvis(Request $request, $id)
{
    $request->validate([
        'nom_utilisateur' => 'required|string|max:255',
        'note' => 'required|numeric|min:1|max:5',
        'commentaire' => 'nullable|string',
    ]);

    Avis::create([
        'vehicule_id' => $id,
        'nom_utilisateur' => $request->nom_utilisateur,
        'note' => $request->note,
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('vehicules.show', $id)->with('success', 'Votre avis a été ajouté avec succès.');
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('show', compact('vehicule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Update the specified resource in storage.
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
            'prix_jour' => 'required|numeric',
            'statut' => 'required|in:disponible,reserve,en_location,maintenance',
            'carburant' => 'required|in:Essence,Diesel,Electrique',
            'nbre_places' => 'nullable|integer|min:1',
            'localisation' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:255',
            'kilometrage' => 'nullable|integer|min:0',
        ]);

        $vehicule->update($validated);

        return redirect()->route('vehicules.index')->with('success', 'Véhicule modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vehicule = Vehicule::findOrFail($id);
        $vehicule->delete();

        return redirect()->route('vehicules.index')->with('success', 'Véhicule supprimé avec succès.');
    }


}
