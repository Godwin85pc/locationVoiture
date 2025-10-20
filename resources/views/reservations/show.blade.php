@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au dashboard
        </a>
    </div>

    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-calendar-check"></i> Détails de la réservation #{{ $reservation->id }}
    </h2>

    <div class="row">
        <!-- Informations de la réservation -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i> Informations générales
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Statut</h6>
                            <span class="badge bg-{{ $reservation->statut === 'confirmee' ? 'success' : ($reservation->statut === 'en_attente' ? 'warning' : ($reservation->statut === 'terminee' ? 'info' : 'secondary')) }} fs-6">
                                {{ ucfirst(str_replace('_', ' ', $reservation->statut)) }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Date de réservation</h6>
                            <p>{{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Date de début</h6>
                            <p><i class="bi bi-calendar-plus text-primary"></i> {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Date de fin</h6>
                            <p><i class="bi bi-calendar-minus text-primary"></i> {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Lieu de récupération</h6>
                            <p><i class="bi bi-geo-alt text-success"></i> {{ $reservation->lieu_recuperation ?? 'Non spécifié' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Lieu de restitution</h6>
                            <p><i class="bi bi-geo text-danger"></i> {{ $reservation->lieu_restitution ?? 'Non spécifié' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Durée</h6>
                            @php
                                $dateDebut = \Carbon\Carbon::parse($reservation->date_debut);
                                $dateFin = \Carbon\Carbon::parse($reservation->date_fin);
                                $duree = $dateDebut->diffInDays($dateFin);
                            @endphp
                            <p><i class="bi bi-clock text-info"></i> {{ $duree }} jour(s)</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Montant total</h6>
                            <h4 class="text-success"><i class="bi bi-currency-euro"></i> {{ number_format($reservation->montant_total, 2) }} €</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($reservation->statut === 'en_attente')
                <div class="card mt-4">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-tools"></i> Actions disponibles
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('reservations.edit', $reservation) }}" class="btn btn-warning">
                                <i class="bi bi-pencil-square"></i> Modifier
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                    <i class="bi bi-x-circle"></i> Annuler
                                </button>
                            </form>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Vous pouvez modifier ou annuler votre réservation tant qu'elle n'a pas été confirmée.
                        </small>
                    </div>
                </div>
            @endif
        </div>

        <!-- Informations du véhicule -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-car-front"></i> Véhicule réservé
                    </h5>
                </div>
                @if($reservation->vehicule)
                    <img src="{{ $reservation->vehicule->photo ?? 'https://via.placeholder.com/400x200?text=Véhicule' }}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;" 
                         alt="{{ $reservation->vehicule->marque }} {{ $reservation->vehicule->modele }}">
                    
                    <div class="card-body">
                        <h5 class="card-title text-success">
                            {{ $reservation->vehicule->marque }} {{ $reservation->vehicule->modele }}
                        </h5>
                        
                        <ul class="list-unstyled">
                            <li><i class="bi bi-calendar text-primary"></i> Année: {{ $reservation->vehicule->annee ?? 'Non spécifiée' }}</li>
                            <li><i class="bi bi-fuel-pump text-primary"></i> {{ $reservation->vehicule->carburant ?? 'Non spécifié' }}</li>
                            <li><i class="bi bi-gear text-primary"></i> {{ $reservation->vehicule->transmission ?? 'Non spécifiée' }}</li>
                            <li><i class="bi bi-people text-primary"></i> {{ $reservation->vehicule->nombre_places ?? $reservation->vehicule->nbre_places ?? 'Non spécifié' }} places</li>
                            @if($reservation->vehicule->climatisation)
                                <li><i class="bi bi-snow text-info"></i> Climatisation</li>
                            @endif
                            @if($reservation->vehicule->gps)
                                <li><i class="bi bi-geo text-info"></i> GPS</li>
                            @endif
                        </ul>

                        <hr>

                        <div class="text-center">
                            <h6 class="text-muted">Prix par jour</h6>
                            <h5 class="text-success">{{ number_format($reservation->vehicule->prix_par_jour, 2) }} €</h5>
                        </div>

                        <div class="d-grid mt-3">
                            <a href="{{ route('vehicules.show', $reservation->vehicule) }}" class="btn btn-outline-success">
                                <i class="bi bi-eye"></i> Voir le véhicule
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            Les informations du véhicule ne sont plus disponibles.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Contact -->
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-telephone"></i> Besoin d'aide ?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        Pour toute question concernant votre réservation, contactez notre service client :
                    </p>
                    <ul class="list-unstyled small">
                        <li><i class="bi bi-telephone text-primary"></i> +33 1 23 45 67 89</li>
                        <li><i class="bi bi-envelope text-primary"></i> support@locationvoiture.fr</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection