<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Vehicule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    /**
     * Store a new avis/review
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:500',
        ]);

        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Vous devez être connecté pour noter un véhicule.');
        }

        // Vérifier si l'utilisateur a déjà noté ce véhicule
        $existingAvis = Avis::where('utilisateur_id', Auth::id())
            ->where('vehicule_id', $validated['vehicule_id'])
            ->first();

        if ($existingAvis) {
            // Mettre à jour l'avis existant
            $existingAvis->update([
                'note' => $validated['note'],
                'commentaire' => $request->input('commentaire'), // Utiliser $request->input()
            ]);

            return redirect()->back()->with('success', 'Votre note a été mise à jour avec succès !');
        }

        // Créer un nouvel avis - CORRECTION ICI
        Avis::create([
            'utilisateur_id' => Auth::id(),
            'vehicule_id' => $validated['vehicule_id'],
            'note' => $validated['note'],
            'commentaire' => $request->input('commentaire'), // Utiliser $request->input() au lieu de $validated
        ]);

        return redirect()->back()->with('success', 'Merci pour votre note !');
    }
}