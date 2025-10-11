<?php
namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class AvisController extends Controller
{
    // Afficher les détails d'un véhicule + ses avis
    public function show($id)
    {
        // Charge les packs et avis associés
        $vehicule = Vehicule::with('avis')->findOrFail($id);
        return view('vehicule_details', compact('vehicule'));
    }

    // Stocker un nouvel avis
   public function storeAvis(Request $request, $vehiculeId)
{
    $request->validate([
        'nom_utilisateur' => 'required|string|max:255',
        'note' => 'required|integer|min:1|max:5',
        'commentaire' => 'required|string|max:1000',
    ]);

    AvisVehicule::create([
        'vehicule_id' => $vehiculeId,
        'nom_utilisateur' => $request->nom_utilisateur,
        'note' => $request->note,
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->back()->with('success', 'Avis publié !');
}


    
}
