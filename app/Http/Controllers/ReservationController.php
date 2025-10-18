<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Vehicule;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource for users.
     */
    public function index()
    {
        $reservations = Reservation::where('client_id', Auth::id())
            ->with(['vehicule'])
            ->orderBy('date_reservation', 'desc')
            ->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Display admin view of all reservations.
     */
    public function adminIndex()
    {
        $reservations = Reservation::with(['client', 'vehicule'])
            ->orderBy('date_reservation', 'desc')
            ->get();
        
        $stats = [
            'total' => $reservations->count(),
            'en_attente' => $reservations->where('statut', 'en_attente')->count(),
            'confirmees' => $reservations->where('statut', 'confirmee')->count(),
            'annulees' => $reservations->where('statut', 'annulee')->count(),
            'revenus' => $reservations->where('statut', 'confirmee')->sum('montant_total')
        ];

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($vehicule_id = null)
    {
        $vehicule = null;
        if ($vehicule_id) {
            $vehicule = Vehicule::findOrFail($vehicule_id);
        }
        return view('reservations.create', compact('vehicule'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu_recuperation' => 'nullable|string|max:255',
            'lieu_restitution' => 'nullable|string|max:255',
        ]);

        $vehicule = Vehicule::findOrFail($validated['vehicule_id']);
        
        // Calculer le montant total
        $dateDebut = new \DateTime($validated['date_debut']);
        $dateFin = new \DateTime($validated['date_fin']);
        $nbJours = $dateDebut->diff($dateFin)->days + 1;
        $montantTotal = $nbJours * $vehicule->prix_jour;

        $reservation = Reservation::create([
            'vehicule_id' => $validated['vehicule_id'],
            'client_id' => Auth::id(),
            'date_debut' => $validated['date_debut'],
            'date_fin' => $validated['date_fin'],
            'montant_total' => $montantTotal,
            'statut' => 'en_attente',
            'date_reservation' => now(),
            'lieu_recuperation' => $validated['lieu_recuperation'],
            'lieu_restitution' => $validated['lieu_restitution'],
        ]);

        return redirect()->route('reservations.index')->with('success', 'Réservation créée avec succès. En attente de validation.');
    }

    /**
     * Validate a reservation (admin only).
     */
    public function validate(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['statut' => 'confirmee']);
        
        // Mettre le véhicule en location
        $reservation->vehicule->update(['statut' => 'loue']);

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation validée avec succès.');
    }

    /**
     * Reject a reservation (admin only).
     */
    public function reject(Request $request, $id)
    {
        $validated = $request->validate([
            'motif_rejet' => 'nullable|string|max:500',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update([
            'statut' => 'annulee',
            'motif_rejet' => $validated['motif_rejet'] ?? 'Réservation rejetée par l\'administrateur'
        ]);

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation rejetée.');
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
