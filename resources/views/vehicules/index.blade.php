@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4 text-primary fw-bold">
        <i class="bi bi-car-front-fill"></i> Nos véhicules disponibles
    </h2>

    <!-- Filtres de recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Filtrer les véhicules</h5>
            <form method="GET" action="{{ route('vehicules.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Lieu de récupération</label>
                        <input type="text" name="lieu_recuperation" class="form-control" 
                               value="{{ request('lieu_recuperation') }}" 
                               placeholder="Entrez une ville...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date début</label>
                        <input type="date" name="date_debut" class="form-control" 
                               value="{{ request('date_debut') }}" 
                               min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date fin</label>
                        <input type="date" name="date_fin" class="form-control" 
                               value="{{ request('date_fin') }}" 
                               min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Rechercher
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des véhicules -->
    <div class="row g-4">
        @forelse($vehicules as $vehicule)
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
                            <li><i class="bi bi-gear text-info"></i> {{ $vehicule->transmission }}</li>
                            <li><i class="bi bi-people text-info"></i> {{ $vehicule->nombre_places }} places</li>
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
                                <h4 class="text-success mb-0">{{ $vehicule->prix_par_jour }} €<small>/jour</small></h4>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('vehicules.show', $vehicule) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Voir détails
                                </a>
                                @auth
                                    <a href="{{ route('reservations.create', $vehicule) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-calendar-plus"></i> Réserver
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-box-arrow-in-right"></i> Se connecter pour réserver
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="bi bi-info-circle"></i> 
                    @if(request()->hasAny(['lieu_recuperation', 'date_debut', 'date_fin']))
                        Aucun véhicule disponible correspondant à vos critères de recherche.
                        <br>
                        <a href="{{ route('vehicules.index') }}" class="btn btn-outline-primary mt-2">
                            Voir tous les véhicules
                        </a>
                    @else
                        Aucun véhicule disponible pour le moment.
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination si nécessaire -->
    @if($vehicules instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $vehicules->links() }}
        </div>
    @endif
</div>
@endsection