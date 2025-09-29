<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'client_id' => 'required|exists:utilisateurs,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'montant_total' => 'required|numeric',
            'statut' => 'required|in:en_attente,confirmee,annulee,terminee',
            'lieu_recuperation' => 'nullable|string|max:255',
            'lieu_restitution' => 'nullable|string|max:255',
        ]);

        Reservation::create($validated);

        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'client_id' => 'required|exists:utilisateurs,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'montant_total' => 'required|numeric',
            'statut' => 'required|in:en_attente,confirmee,annulee,terminee',
            'lieu_recuperation' => 'nullable|string|max:255',
            'lieu_restitution' => 'nullable|string|max:255',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.index')->with('success', 'Réservation modifiée avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Réservation supprimée avec succès.');
    }
}
