<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicule;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehiculeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vehicule::where('disponible', true);

        // Filtrer par lieu de récupération si fourni
        if ($request->filled('lieu_recuperation')) {
            $query->where('localisation', 'like', '%' . $request->lieu_recuperation . '%');
        }

        // Filtrer par dates si fournies
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            // Vérifier que le véhicule n'est pas déjà réservé sur cette période
            $dateDebut = $request->date_debut;
            $dateFin = $request->date_fin;
            
            $vehiculesReserves = Reservation::where(function($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_debut', [$dateDebut, $dateFin])
                  ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                  ->orWhere(function($subQ) use ($dateDebut, $dateFin) {
                      $subQ->where('date_debut', '<=', $dateDebut)
                           ->where('date_fin', '>=', $dateFin);
                  });
            })->pluck('vehicule_id');

            $query->whereNotIn('id', $vehiculesReserves);
        }

        $vehicules = $query->with('proprietaire')->get();

        return view('vehicules.index', compact('vehicules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('01-ajout_voiture');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([  
        'marque' => 'required|string|max:255',
        'modele' => 'required|string|max:255',
        'date_ajout' => 'required|date',
        'type' => 'nullable|in:SUV,Berline,Utilitaire,Citadine',
        'prix_jour' => 'nullable|numeric|min:0',
        'description' => 'nullable|string',
        'numero_plaque' => 'required|string|max:255|unique:vehicules',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'localisation' => 'required|string|max:255',
        'carburant' => 'required|in:essence,diesel,electrique,hybride',
        'nbre_places' => 'nullable|integer|min:2|max:9',
        'kilometrage' => 'nullable|integer|min:0',
    ]);

    $vehicule = new Vehicule();
    $vehicule->proprietaire_id = Auth::id();
    $vehicule->marque = $request->marque;
    $vehicule->modele = $request->modele;
    $vehicule->numero_plaque = $request->numero_plaque; // ✅ bien utilisé ici
    $vehicule->date_ajout = $request->date_ajout;
    $vehicule->nbre_places = $request->nbre_places ?? 4; // valeur par défaut si vide
    $vehicule->type = $request->type ?? 'Citadine';
    $vehicule->description = $request->description ?? '';
    $vehicule->localisation = $request->localisation;
    $vehicule->carburant = ucfirst(strtolower($request->carburant));
    $vehicule->kilometrage = $request->kilometrage ?? 0;
    $vehicule->disponible = true;
    $vehicule->statut = 'en_attente';

    // Calcul automatique du prix si non fourni
    $vehicule->prix_par_jour = $request->prix_jour ?? $this->calculerPrixAutomatique($vehicule->type, $vehicule->carburant);

    // Gestion de l'upload de photo
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('vehicules', 'public');
        $vehicule->photo = Storage::url($path);
    }

    $vehicule->save();

    // Stocker en session pour la page de résumé
    session(['vehicule' => $vehicule->toArray()]);

    // Redirection vers l'étape suivante
    return redirect()->route('02-options_extras')
        ->with('success', 'Véhicule soumis avec succès ! Il sera examiné par notre équipe.')
        ->with('vehicule_id', $vehicule->id);
}


    /**
     * Display the specified resource.
     */
    public function show(Vehicule $vehicule)
    {
        return view('vehicules.show', compact('vehicule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicule $vehicule)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce véhicule.');
        }

        return view('vehicules.edit', compact('vehicule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicule $vehicule)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier ce véhicule.');
        }

        $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'date_ajout' => 'nullable|date|',
            'numero_plaque' => 'required|string|max:255|unique:vehicules,numero_plaque,' . $vehicule->id,
            'prix_jour' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'localisation' => 'required|string|max:255',
            'carburant' => 'required|in:essence,diesel,electrique,hybride',
            'transmission' => 'required|in:manuelle,automatique',
            'nbre_places' => 'nullable|integer|min:2|max:9',
        ]);

        $vehicule->marque = $request->marque;
        $vehicule->modele = $request->modele;
        $vehicule->date_ajout = $request->date_ajout;
        $vehicule->numero_plaque = $request->numero_plaque;
        $vehicule->prix_jour = $request->prix_par_jour;
        $vehicule->description = $request->description;
        $vehicule->localisation = $request->localisation;
        $vehicule->carburant = $request->carburant;
        $vehicule->transmission = $request->transmission;
        $vehicule->nbre_places = $request->nbre_places;
        $vehicule->climatisation = $request->has('climatisation');
        $vehicule->gps = $request->has('gps');

        // Gestion de l'upload de photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($vehicule->photo && Storage::disk('public')->exists(str_replace('/storage/', '', $vehicule->photo))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $vehicule->photo));
            }
            
            $path = $request->file('photo')->store('vehicules', 'public');
            $vehicule->photo = Storage::url($path);
        }

        $vehicule->save();

        return redirect()->route('dashboard')->with('success', 'Véhicule modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicule $vehicule)
    {
        // Vérifier que l'utilisateur est le propriétaire du véhicule
        if ($vehicule->proprietaire_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer ce véhicule.');
        }

        // Vérifier qu'il n'y a pas de réservations actives
        $reservationsActives = $vehicule->reservations()
            ->where('statut', '!=', 'annulee')
            ->where('date_fin', '>=', now())
            ->count();

        if ($reservationsActives > 0) {
            return redirect()->route('dashboard')
                ->with('error', 'Impossible de supprimer ce véhicule car il a des réservations actives.');
        }

        // Supprimer la photo si elle existe
        if ($vehicule->photo && Storage::disk('public')->exists(str_replace('/storage/', '', $vehicule->photo))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $vehicule->photo));
        }

        $vehicule->delete();

        return redirect()->route('dashboard')->with('success', 'Véhicule supprimé avec succès !');
    }
 
   
    /**
     * API endpoint pour récupérer les offres disponibles (utilisé par JavaScript)
     */
   public function offresDisponibles()
    {
        $vehicules = Vehicule::where('disponible', true)
            ->with('proprietaire')
            ->get()
            ->map(function($vehicule) {
                return [
                    'id' => $vehicule->id,
                    'marque' => $vehicule->marque,
                    'modele' => $vehicule->modele,
                    'photo' => $vehicule->photo,
                    'prix_par_jour' => $vehicule->prix_par_jour,
                    'description' => $vehicule->description,
                    'carburant' => $vehicule->carburant,
                    'transmission' => $vehicule->transmission,
                    'nbre_places' => $vehicule->nbre_places,
                    'climatisation' => $vehicule->climatisation,
                    'gps' => $vehicule->gps,
                    'localisation' => $vehicule->localisation,
                ];
            });

        return response()->json($vehicules);
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
     * Recherche de véhicules pour le formulaire de récapitulatif
     */
    public function rechercher(Request $request)
    {
        // Version simplifiée pour le debug - validation plus permissive
        $request->validate([
            'lieu_recuperation' => 'required|string',
            'dateDepart' => 'required|date',
            'heureDepart' => 'required',
            'lieu_restitution' => 'required|string',
            'dateRetour' => 'required|date',
            'heureRetour' => 'required',
        ]);

        $dateDebutComplete = $request->dateDepart . ' ' . $request->heureDepart;
        $dateFinComplete = $request->dateRetour . ' ' . $request->heureRetour;

        // Rechercher les véhicules disponibles - version simplifiée
        $vehiculesDisponibles = Vehicule::where('disponible', true)
            ->where('localisation', 'like', '%' . $request->lieu_recuperation . '%')
            ->get();

        // Si aucun véhicule avec localisation, prendre tous les véhicules disponibles
        if ($vehiculesDisponibles->isEmpty()) {
            $vehiculesDisponibles = Vehicule::where('disponible', true)->get();
        }

        // Stocker les critères de recherche en session
        session([
            'recherche' => [
                'lieu_recuperation' => $request->lieu_recuperation,
                'dateDepart' => $request->dateDepart,
                'heureDepart' => $request->heureDepart,
                'lieu_restitution' => $request->lieu_restitution,
                'dateRetour' => $request->dateRetour,
                'heureRetour' => $request->heureRetour,
                'ageCheck' => $request->has('ageCheck'),
            ]
        ]);

        return view('recapitulatif', compact('vehiculesDisponibles'));
    }

    /**
     * Ajouter un avis pour un véhicule
     */
    public function storeAvis(Request $request, Vehicule $vehicule)
    {
        // Rediriger vers le contrôleur AvisController
        $request->merge(['vehicule_id' => $vehicule->id]);
        $avisController = new \App\Http\Controllers\AvisController();
        return $avisController->store($request);
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
     * Page de résumé après ajout de véhicule
     */
   
    /**
     * 🔧 Fonction privée : calcule le prix selon type et carburant
     */
    private function calculerPrixAutomatique($type, $carburant)
    {
        $prixType = [
            'SUV' => 250,
            'Berline' => 200,
            'Utilitaire' => 300,
            'Citadine' => 150,
        ];

        // Supplément carburant
        $supCarburant = [
            'Essence' => 0,
            'Diesel' => 20,
            'Electrique' => 50,
        ];

        // Calcul du prix en euros (pas en centimes)
        return ($prixType[$type] ?? 200) + ($supCarburant[$carburant] ?? 0);
    }

    /**
     * Calculer le prix d'un véhicule selon des critères (API)
     */
    public function calculPrix(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'carburant' => 'required|string',
            'duree' => 'integer|min:1',
            'lieu_recuperation' => 'string',
            'lieu_retour' => 'string',
        ]);

        $prixBase = $this->calculerPrixAutomatique($validated['type'], $validated['carburant']);
        $duree = $validated['duree'] ?? 1;
        
        // Calculs supplémentaires selon les critères
        $prixTotal = $prixBase * $duree;
        
        // Majoration si lieux différents
        if (isset($validated['lieu_recuperation']) && isset($validated['lieu_retour']) &&
            $validated['lieu_recuperation'] !== $validated['lieu_retour']) {
            $prixTotal += 50; // Frais de déplacement
        }

        return response()->json([
            'prix_jour' => $prixBase,
            'duree' => $duree,
            'prix_total' => $prixTotal,
            'details' => [
                'type' => $validated['type'],
                'carburant' => $validated['carburant'],
                'lieux_differents' => ($validated['lieu_recuperation'] ?? '') !== ($validated['lieu_retour'] ?? '')
            ]
        ]);
    }

    /**
     * Gère l'étape 1 du processus de création de véhicule (informations de base)
     */
    public function storeStep1(Request $request)
    {
        // Validation des données de base
        $validated = $request->validate([
            'marque' => 'required|string|max:255',
            'modele' => 'required|string|max:255',
            'localisation' => 'required|string|max:255',
            'type' => 'required|in:SUV,Berline,Utilitaire,Citadine',
            // Accepter minuscules et majuscules pour correspondre aux valeurs du formulaire
            'carburant' => 'required|in:essence,diesel,electrique,hybride,Essence,Diesel,Electrique,Hybride',
            'nbre_places' => 'nullable|integer|min:2|max:9',
            'date_ajout' => 'nullable|date|',
            'kilometrage' => 'nullable|integer|min:0',
            'couleur' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Normaliser la valeur du carburant pour cohérence inter-étapes
        if (isset($validated['carburant'])) {
            $validated['carburant'] = ucfirst(strtolower($validated['carburant']));
        }

        // Si une photo est uploadée, l'enregistrer et stocker UNIQUEMENT le chemin dans la session
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('vehicules', 'public');
            // Conserver le chemin accessible publiquement
            $validated['photo_path'] = \Illuminate\Support\Facades\Storage::url($path);
        }

        // Ne pas stocker l'objet UploadedFile en session (sécurité)
        if (isset($validated['photo'])) {
            unset($validated['photo']);
        }

        // Stocker les données en session pour les étapes suivantes
        session(['vehicule_step1' => $validated]);

        // Rediriger vers l'étape suivante
        return redirect()->route('02-options_extras')->with('step1_data', $validated);
    }

    /**
     * Gère l'étape 2 du processus (options extras)
     */
    public function storeStep2(Request $request)
    {
        $validated = $request->validate([
            'climatisation' => 'nullable|boolean',
            'gps' => 'nullable|boolean',
            'bluetooth' => 'nullable|boolean',
            'sieges_chauffants' => 'nullable|boolean',
            'toit_ouvrant' => 'nullable|boolean',
        ]);

        session(['vehicule_step2' => $validated]);
        return redirect()->route('03-maintenance');
    }

    /**
     * Gère l'étape 3 du processus (maintenance)
     */
    public function storeStep3(Request $request)
    {
        $validated = $request->validate([
            'derniere_revision' => 'nullable|date',
            'prochaine_revision' => 'nullable|date',
            'assurance_expire' => 'nullable|date',
            'controle_technique' => 'nullable|date',
        ]);

        session(['vehicule_step3' => $validated]);
        // Aller directement à l'étape 05 (suppression de l'étape 04)
        return redirect()->route('05-set_prices');
    }

    /**
     * Gère l'étape 4 du processus (informations de prix)
     */
    public function storeStep4(Request $request)
    {
        $validated = $request->validate([
            'prix_par_jour' => 'required|numeric|min:1',
            'caution' => 'nullable|numeric|min:0',
            'frais_livraison' => 'nullable|numeric|min:0',
        ]);

        session(['vehicule_step4' => $validated]);
        // Après enregistrement du prix, passer à la confirmation
        return redirect()->route('confirmation');
    }

    /**
     * Gère l'étape 5 du processus (finalisation et sauvegarde)
     */
    public function storeStep5(Request $request)
    {
        // Récupérer toutes les données des étapes précédentes
        $step1 = session('vehicule_step1', []);
        $step2 = session('vehicule_step2', []);
        $step3 = session('vehicule_step3', []);
        $step4 = session('vehicule_step4', []);

        // Créer le véhicule avec toutes les données
        $vehicule = new Vehicule();
        
        // Données de base (étape 1)
        $vehicule->marque = $step1['marque'];
        $vehicule->modele = $step1['modele'];
        $vehicule->localisation = $step1['localisation'];
    $vehicule->type = $step1['type'];
    // Normaliser le carburant pour l'ENUM BD
    $vehicule->carburant = ucfirst(strtolower($step1['carburant']));
    // nombre_places setter mappe vers nbre_places si utilisé; ici nous pouvons utiliser nbre_places directement
    $vehicule->nbre_places = $step1['nbre_places'];
    $vehicule->kilometrage = $step1['kilometrage'] ?? 0;
    $vehicule->description = $step1['description'] ?? '';
        
        // Données de prix (étape 4)
    $vehicule->prix_par_jour = $step4['prix_par_jour'];
        
        // Données par défaut
        $vehicule->disponible = true;
        $vehicule->proprietaire_id = Auth::user()->id;
        $vehicule->statut = 'en_attente'; // En attente de validation admin

        // Gestion de la photo si elle existe (chemin sauvegardé à l'étape 1)
        if (isset($step1['photo_path'])) {
            $vehicule->photo = $step1['photo_path'];
        }

        $vehicule->save();

        // Nettoyer les données de session
        session()->forget(['vehicule_step1', 'vehicule_step2', 'vehicule_step3', 'vehicule_step4']);

        return redirect()->route('dashboard')
            ->with('success', 'Votre véhicule a été ajouté avec succès et est en attente de validation !');
    }
}

