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
        $reservations = Reservation::where('utilisateur_id', Auth::id())
            ->with(['vehicule'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Display admin view of all reservations.
     */
    public function adminIndex()
    {
        $reservations = Reservation::with(['utilisateur', 'vehicule'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total' => $reservations->count(),
            'en_attente' => $reservations->where('statut', 'en_attente')->count(),
            'confirmees' => $reservations->where('statut', 'confirmee')->count(),
            'annulees' => $reservations->where('statut', 'annulee')->count(),
            'revenus' => $reservations->where('statut', 'confirmee')->sum('prix_total')
        ];

        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $vehicule = Vehicule::findOrFail($request->vehicule_id);
        
        $pack = $request->pack; // 'standard' ou 'premium'
        $prix = $request->prix;
        $nombreJours = $request->nombre_jours;
        
        return view('reservation', compact('vehicule', 'pack', 'prix', 'nombreJours'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    $data = $request->validate([
        'vehicule_id' => 'required|exists:vehicules,id',
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after:date_debut',
        'pack' => 'required|in:standard,premium',
        'montant_total' => 'required|numeric|min:0',
        'nom' => 'required|string|max:100',
        'prenom' => 'required|string|max:100',
        'email' => 'required|email',
        'telephone' => 'required|string|max:20',
        'lieu_recuperation' => 'required|string|max:255',
        'lieu_restitution' => 'required|string|max:255',
    ]);

    $data['client_id'] = Auth::id();    // utilisateur connecté
    $data['statut'] = 'en_attente';     // statut par défaut

    // Créer la réservation
    $reservation = Reservation::create($data);

    // Mettre le véhicule en location si ton système le permet
    $vehicule = Vehicule::findOrFail($data['vehicule_id']);
    $vehicule->update(['statut' => 'loue']); // Assurez-vous que 'loue' est autorisé dans vehicules.statut

    // Redirection avec message flash (affiché côté client)
    return redirect()->route('dashboard')->with('success', 
        'Réservation enregistrée avec succès ! Le lieu de récupération vous sera communiqué par mail après validation.');
}



    /**
     * Validate a reservation (admin only).
     */
    public function validate(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['statut' => 'confirmee']);
        
        return redirect()->route('admin.reservations.index')->with('success', 'Réservation validée ! Le client recevra le lieu de récupération par mail.');
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

        // Remettre le véhicule disponible
        $reservation->vehicule->update(['statut' => 'disponible']);

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation rejetée.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['vehicule', 'utilisateur'])->findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        
        // Remettre le véhicule disponible
        $reservation->vehicule->update(['statut' => 'disponible']);
        
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Réservation annulée avec succès.');
    }
}