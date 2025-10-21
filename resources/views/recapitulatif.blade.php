@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour au dashboard
        </a>
    </div>

    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-car-front-fill"></i> Résultats de recherche
    </h2>

    @if(session('recherche'))
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Critères de recherche</h5>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Lieu de récupération :</strong><br>
                        {{ session('recherche.lieu_recuperation') }}
                    </div>
                    <div class="col-md-3">
                        <strong>Départ :</strong><br>
                        {{ session('recherche.dateDepart') }} à {{ session('recherche.heureDepart') }}
                    </div>
                    <div class="col-md-3">
                        <strong>Retour :</strong><br>
                        {{ session('recherche.dateRetour') }} à {{ session('recherche.heureRetour') }}
                    </div>
                    <div class="col-md-3">
                        <strong>Lieu de restitution :</strong><br>
                        {{ session('recherche.lieu_restitution') }}
                    </div>

                    <div class="col-md-6">
                <strong>Véhicules trouvés :</strong> {{ $vehiculesDisponibles->count() }}
                    </div>

            <!-- Bouton Modifier la recherche -->
                <div class="d-flex justify-content-center mt-3">
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 shadow">
                <i class="bi bi-search"></i> Modifier la recherche
            </a>
        </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Liste des véhicules disponibles -->
    <div class="row g-4">
        @forelse($vehiculesDisponibles as $vehicule)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $vehicule->photo ?? 'https://img.leboncoin.fr/api/v1/lbcpb1/images/fd/98/d5/fd98d5e6dfcc55e5aaf297dff5309730e3293c3d.jpg?rule=ad-large' }}" 
                         class="card-img-top" 
                         style="height: 200px; object-fit: cover;" 
                         alt="{{ $vehicule->marque }} {{ $vehicule->modele }}">
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary fw-bold">
                            {{ $vehicule->marque }} {{ $vehicule->modele }}
                        </h5>
                        
                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="bi bi-geo-alt"></i> {{ $vehicule->localisation }}
                            </small>
                        </div>

                        <ul class="list-unstyled small mb-3">
                            <li><i class="bi bi-fuel-pump text-info"></i> {{ $vehicule->carburant }}</li>
                            <li><i class="bi bi-gear text-info"></i> {{ $vehicule->transmission ?? 'Automatique' }}</li>
                            <li><i class="bi bi-people text-info"></i> {{ $vehicule->nombre_places ?? $vehicule->nbre_places }} places</li>
                            @if($vehicule->climatisation)
                                <li><i class="bi bi-snow text-info"></i> Climatisation</li>
                            @endif
                            @if($vehicule->gps)
                                <li><i class="bi bi-geo text-info"></i> GPS</li>
                            @endif
                        </ul>

                        @if($vehicule->description)
                            <p class="card-text text-muted flex-grow-1">
                                {{ Str::limit($vehicule->description, 100) }}
                            </p>
                        @endif

                        @php
                            $noteMoyenne = $vehicule->avis->avg('note') ?? 0;
                            $nombreAvis = $vehicule->avis->count();
                        @endphp
                        
                        @if($nombreAvis > 0)
                            <div class="mb-2">
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $noteMoyenne)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <small class="text-muted">{{ number_format($noteMoyenne, 1) }} ({{ $nombreAvis }} avis)</small>
                            </div>
                        @endif

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="text-success mb-0">{{ $vehicule->prix_par_jour ?? $vehicule->prix_jour }} €<small>/jour</small></h4>
                            </div>

                            <div class="mb-2">
                                <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-outline-primary btn-sm w-100">
                                    <i class="bi bi-eye"></i> Voir détails
                                </a>
                            </div>

                            @php
                                $crit = session('recherche', []);
                                $dateDebut = isset($crit['dateDepart']) ? \Carbon\Carbon::parse(($crit['dateDepart'] ?? '') . ' ' . ($crit['heureDepart'] ?? '00:00')) : null;
                                $dateFin = isset($crit['dateRetour']) ? \Carbon\Carbon::parse(($crit['dateRetour'] ?? '') . ' ' . ($crit['heureRetour'] ?? '00:00')) : null;
                                $nombreJours = ($dateDebut && $dateFin) ? max(1, $dateDebut->diffInDays($dateFin)) : 1;
                                $prixJour = $vehicule->prix_par_jour ?? $vehicule->prix_jour;
                                $prixStandard = $nombreJours * ($prixJour ?? 0);
                                $prixPremium = round($prixStandard * 1.3, 2); // Aligné avec ReservationController
                            @endphp

                            <!-- PACK STANDARD -->
                            <div class="card mb-2 border-primary">
                                <div class="card-header bg-primary text-white py-1">
                                    <h6 class="mb-0" style="font-size: 0.95rem;"><i class="fas fa-box"></i> PACK STANDARD</h6>
                                </div>
                                <div class="card-body py-2">
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="fas fa-check text-success"></i> Responsabilité civile</li>
                                        <li><i class="fas fa-check text-success"></i> Assurance tous risques avec franchise</li>
                                        <li><i class="fas fa-check text-success"></i> {{ number_format($nombreJours * 750) }} Km inclus</li>
                                        <li><i class="fas fa-check text-success"></i> Annulation gratuite</li>
                                    </ul>
                                    <div class="text-center mb-2">
                                        <p class="mb-1"><span class="badge bg-info">{{ $nombreJours }} jour(s)</span></p>
                                        <h5 class="text-primary mb-0">{{ number_format($prixStandard, 2) }} €</h5>
                                        <small class="text-muted">({{ number_format($prixJour ?? 0, 2) }} €/jour)</small>
                                    </div>
                                    <a href="{{ route('reservations.create', [
                                        'vehicule' => $vehicule->id,
                                        'pack' => 'standard',
                                        'date_debut' => $crit['dateDepart'] ?? null,
                                        'date_fin' => $crit['dateRetour'] ?? null,
                                        'lieu_recuperation' => $crit['lieu_recuperation'] ?? null,
                                        'lieu_restitution' => $crit['lieu_restitution'] ?? null,
                                    ]) }}" class="btn btn-primary w-100 btn-sm">
                                        <i class="fas fa-calendar-check"></i> Réserver
                                    </a>
                                </div>
                            </div>

                            <!-- PACK PREMIUM -->
                            <div class="card mb-2 border-warning">
                                <div class="card-header bg-warning text-dark py-1">
                                    <h6 class="mb-0" style="font-size: 0.95rem;"><i class="fas fa-crown"></i> PACK PREMIUM</h6>
                                </div>
                                <div class="card-body py-2">
                                    <ul class="list-unstyled mb-2 small">
                                        <li><i class="fas fa-check text-success"></i> Responsabilité civile</li>
                                        <li><i class="fas fa-check text-success"></i> Assurance tous risques</li>
                                        <li><i class="fas fa-check text-success"></i> <strong>Remboursement des franchises</strong></li>
                                        <li><i class="fas fa-check text-success"></i> {{ number_format($nombreJours * 1000) }} Km inclus</li>
                                        <li><i class="fas fa-check text-success"></i> GPS inclus</li>
                                        <li><i class="fas fa-check text-success"></i> Conducteur additionnel gratuit</li>
                                    </ul>
                                    <div class="text-center mb-2">
                                        <p class="mb-1">
                                            <span class="badge bg-info">{{ $nombreJours }} jour(s)</span>
                                            <span class="badge bg-success">+30%</span>
                                        </p>
                                        <h5 class="text-warning mb-0">{{ number_format($prixPremium, 2) }} €</h5>
                                        <small class="text-muted">({{ number_format(($prixPremium / max(1,$nombreJours)), 2) }} €/jour)</small>
                                    </div>
                                    <a href="{{ route('reservations.create', [
                                        'vehicule' => $vehicule->id,
                                        'pack' => 'premium',
                                        'date_debut' => $crit['dateDepart'] ?? null,
                                        'date_fin' => $crit['dateRetour'] ?? null,
                                        'lieu_recuperation' => $crit['lieu_recuperation'] ?? null,
                                        'lieu_restitution' => $crit['lieu_restitution'] ?? null,
                                    ]) }}" class="btn btn-warning w-100 btn-sm text-dark">
                                        <i class="fas fa-crown"></i> Réserver
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle"></i> 
                    Aucun véhicule disponible pour vos critères de recherche.
                    <br>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">
                        <i class="bi bi-search"></i> Essayer une autre recherche
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection