<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource for users.
     */
    public function index()
    {
        $reservations = Reservation::where('client_id', Auth::id())
            ->with('vehicule')
            ->orderBy('created_at', 'desc')
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
    public function create(Vehicule $vehicule, Request $request)
    {
        // Récupérer le pack depuis les paramètres de requête, par défaut "standard"
        $pack = $request->get('pack', 'standard');
        
        // Calculer le nombre de jours (par défaut 1 jour si pas de dates spécifiées)
        $nombreJours = 1;
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $dateDebut = new \DateTime($request->date_debut);
            $dateFin = new \DateTime($request->date_fin);
            $nombreJours = max(1, $dateDebut->diff($dateFin)->days);
        }
        
        // Calculer le prix selon le pack
        $prixParJour = $vehicule->prix_par_jour;
        $multiplicateurPack = $pack === 'premium' ? 1.3 : 1; // 30% de plus pour premium
        $prix = $nombreJours * $prixParJour * $multiplicateurPack;
        
        return view('reservations.create', compact('vehicule', 'pack', 'nombreJours', 'prix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicule_id' => 'required|exists:vehicules,id',
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'lieu_recuperation' => 'required|string|max:255',
            'lieu_restitution' => 'required|string|max:255',
        ]);

        $vehicule = Vehicule::findOrFail($request->vehicule_id);

        // Vérifier que le véhicule est disponible
        if (!$vehicule->disponible) {
            return redirect()->back()->with('error', 'Ce véhicule n\'est plus disponible.');
        }

        // Vérifier qu'il n'y a pas de conflit de dates
        $conflits = Reservation::where('vehicule_id', $request->vehicule_id)
            ->where('statut', '!=', 'annulee')
            ->where(function($q) use ($request) {
                $q->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                  ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->where('date_debut', '<=', $request->date_debut)
                           ->where('date_fin', '>=', $request->date_fin);
                  });
            })
            ->exists();

        if ($conflits) {
            return redirect()->back()->with('error', 'Ce véhicule est déjà réservé sur cette période.');
        }

        // Calculer le montant total
        $dateDebut = new \DateTime($request->date_debut);
        $dateFin = new \DateTime($request->date_fin);
        $nombreJours = $dateDebut->diff($dateFin)->days;
        $montantTotal = $nombreJours * $vehicule->prix_par_jour;

        $reservation = new Reservation();
        $reservation->client_id = Auth::id();
        $reservation->vehicule_id = $request->vehicule_id;
        $reservation->date_debut = $request->date_debut;
        $reservation->date_fin = $request->date_fin;
        $reservation->lieu_recuperation = $request->lieu_recuperation;
        $reservation->lieu_restitution = $request->lieu_restitution;
        $reservation->montant_total = $montantTotal;
        $reservation->statut = 'en_attente';
        $reservation->save();

        return redirect()->route('dashboard')->with('success', 'Réservation créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        // Vérifier que l'utilisateur peut voir cette réservation
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir cette réservation.');
        }

        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        // Vérifier que l'utilisateur peut modifier cette réservation
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette réservation.');
        }

        // Ne pas permettre la modification si la réservation est confirmée ou terminée
        if (in_array($reservation->statut, ['confirmee', 'terminee'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut plus être modifiée.');
        }

        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        // Vérifier que l'utilisateur peut modifier cette réservation
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette réservation.');
        }

        // Ne pas permettre la modification si la réservation est confirmée ou terminée
        if (in_array($reservation->statut, ['confirmee', 'terminee'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut plus être modifiée.');
        }

        $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
            'lieu_recuperation' => 'required|string|max:255',
            'lieu_restitution' => 'required|string|max:255',
        ]);

        // Vérifier qu'il n'y a pas de conflit de dates (en excluant cette réservation)
        $conflits = Reservation::where('vehicule_id', $reservation->vehicule_id)
            ->where('id', '!=', $reservation->id)
            ->where('statut', '!=', 'annulee')
            ->where(function($q) use ($request) {
                $q->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                  ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                  ->orWhere(function($subQ) use ($request) {
                      $subQ->where('date_debut', '<=', $request->date_debut)
                           ->where('date_fin', '>=', $request->date_fin);
                  });
            })
            ->exists();

        if ($conflits) {
            return redirect()->back()->with('error', 'Ce véhicule est déjà réservé sur cette période.');
        }

        // Recalculer le montant total
        $dateDebut = new \DateTime($request->date_debut);
        $dateFin = new \DateTime($request->date_fin);
        $nombreJours = $dateDebut->diff($dateFin)->days;
        $montantTotal = $nombreJours * $reservation->vehicule->prix_par_jour;

        $reservation->date_debut = $request->date_debut;
        $reservation->date_fin = $request->date_fin;
        $reservation->lieu_recuperation = $request->lieu_recuperation;
        $reservation->lieu_restitution = $request->lieu_restitution;
        $reservation->montant_total = $montantTotal;
        $reservation->save();

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Réservation modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        // Vérifier que l'utilisateur peut supprimer cette réservation
        if ($reservation->client_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette réservation.');
        }

        // Ne pas permettre la suppression si la réservation est confirmée ou terminée
        if (in_array($reservation->statut, ['confirmee', 'terminee'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut pas être supprimée.');
        }

        $reservation->statut = 'annulee';
        $reservation->save();

        return redirect()->route('dashboard')->with('success', 'Réservation annulée avec succès !');
    }
}
