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
                </div>
            </div>
        </div>
    @endif

    <!-- Liste des véhicules disponibles -->
    <div class="row g-4">
        @forelse($vehiculesDisponibles as $vehicule)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $vehicule->photo ?? 'https://via.placeholder.com/400x200?text=Véhicule' }}" 
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
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Voir détails
                                </a>
                                <a href="{{ route('reservations.create', $vehicule) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-calendar-plus"></i> Réserver maintenant
                                </a>
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