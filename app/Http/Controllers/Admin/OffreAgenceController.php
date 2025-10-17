<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OffreVehicule;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OffreAgenceController extends Controller
{
    /**
     * Afficher la liste des offres d'agence
     */
    public function index()
    {
        $offres = OffreVehicule::with('vehicule')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.offres.index', compact('offres'));
    }

    /**
     * Afficher le formulaire de création d'offre
     */
    public function create()
    {
        // Récupérer les véhicules disponibles appartenant à des admins (véhicules d'agence)
        $vehicules = Vehicule::whereHas('proprietaire', function($query) {
                $query->where('role', 'admin');
            })
            ->where('disponible', true)
            ->get();
            
        return view('admin.offres.create', compact('vehicules'));
    }

    /**
     * Enregistrer une nouvelle offre d'agence
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'prix_par_jour' => 'required|numeric|min:0',
            'description_offre' => 'nullable|string|max:1000',
            'date_debut_offre' => 'required|date|after_or_equal:today',
            'date_fin_offre' => 'required|date|after:date_debut_offre',
            'reduction_pourcentage' => 'nullable|numeric|min:0|max:100',
            'conditions_speciales' => 'nullable|string|max:1000'
        ]);

        $vehicule = Vehicule::findOrFail($request->vehicule_id);
        
        // Vérifier que c'est bien un véhicule d'agence (appartenant à un admin)
        if (!$vehicule->proprietaire || $vehicule->proprietaire->role !== 'admin') {
            return back()->withErrors(['vehicule_id' => 'Seuls les véhicules d\'agence peuvent être mis en offre.']);
        }

        OffreVehicule::create([
            'vehicule_id' => $request->vehicule_id,
            'prix_par_jour' => $request->prix_par_jour,
            'description_offre' => $request->description_offre,
            'date_debut_offre' => $request->date_debut_offre,
            'date_fin_offre' => $request->date_fin_offre,
            'reduction_pourcentage' => $request->reduction_pourcentage ?? 0,
            'conditions_speciales' => $request->conditions_speciales,
            'statut' => 'active',
            'created_by' => Auth::id()
        ]);

        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre d\'agence créée avec succès !');
    }

    /**
     * Afficher les détails d'une offre
     */
    public function show(OffreVehicule $offre)
    {
        $offre->load('vehicule');
        return view('admin.offres.show', compact('offre'));
    }

    /**
     * Afficher le formulaire d'édition d'offre
     */
    public function edit(OffreVehicule $offre)
    {
        $vehicules = Vehicule::whereHas('proprietaire', function($query) {
                $query->where('role', 'admin');
            })
            ->where('disponible', true)
            ->get();
            
        return view('admin.offres.edit', compact('offre', 'vehicules'));
    }

    /**
     * Mettre à jour une offre
     */
    public function update(Request $request, OffreVehicule $offre)
    {
        $request->validate([
            'prix_par_jour' => 'required|numeric|min:0',
            'description_offre' => 'nullable|string|max:1000',
            'date_debut_offre' => 'required|date',
            'date_fin_offre' => 'required|date|after:date_debut_offre',
            'reduction_pourcentage' => 'nullable|numeric|min:0|max:100',
            'conditions_speciales' => 'nullable|string|max:1000',
            'statut' => 'required|in:active,inactive,expired'
        ]);

        $offre->update([
            'prix_par_jour' => $request->prix_par_jour,
            'description_offre' => $request->description_offre,
            'date_debut_offre' => $request->date_debut_offre,
            'date_fin_offre' => $request->date_fin_offre,
            'reduction_pourcentage' => $request->reduction_pourcentage ?? 0,
            'conditions_speciales' => $request->conditions_speciales,
            'statut' => $request->statut
        ]);

        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre mise à jour avec succès !');
    }

    /**
     * Supprimer une offre
     */
    public function destroy(OffreVehicule $offre)
    {
        $offre->delete();
        
        return redirect()->route('admin.offres.index')
            ->with('success', 'Offre supprimée avec succès !');
    }

    /**
     * Activer/désactiver une offre
     */
    public function toggleStatus(OffreVehicule $offre)
    {
        $newStatus = $offre->statut === 'active' ? 'inactive' : 'active';
        $offre->update(['statut' => $newStatus]);
        
        $message = $newStatus === 'active' ? 'Offre activée' : 'Offre désactivée';
        
        return redirect()->back()->with('success', $message . ' avec succès !');
    }
}
