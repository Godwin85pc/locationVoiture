<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::all();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('paiements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant' => 'required|numeric',
            'mode' => 'required|in:carte,paypal,cash',
            'statut' => 'required|in:en_attente,valide,echoue',
        ]);

        Paiement::create($validated);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('paiements.edit', compact('paiement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        $validated = $request->validate([
            'reservation_id' => 'required|exists:reservations,id',
            'montant' => 'required|numeric',
            'mode' => 'required|in:carte,paypal,cash',
            'statut' => 'required|in:en_attente,valide,echoue',
        ]);

        $paiement->update($validated);

        return redirect()->route('paiements.index')->with('success', 'Paiement modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}
