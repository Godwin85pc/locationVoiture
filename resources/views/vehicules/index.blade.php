<<<<<<< HEAD
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des véhicules</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #6a11cb, #2575fc); }
    .card { border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card p-4">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-car-side"></i> Liste des véhicules
      </h3>

      <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('vehicules.create') }}" class="btn btn-success">
          <i class="fas fa-plus"></i> Ajouter un véhicule
        </a>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Retour au dashboard
        </a>
      </div>

      @if($vehicules->count() > 0)
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Type</th>
                <th>Immatriculation</th>
                <th>Prix/jour</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($vehicules as $vehicule)
              <tr>
                <td>{{ $vehicule->marque }}</td>
                <td>{{ $vehicule->modele }}</td>
                <td>{{ $vehicule->type }}</td>
                <td>{{ $vehicule->immatriculation }}</td>
                <td>{{ $vehicule->prix_jour }}€</td>
                <td>
                  <span class="badge {{ $vehicule->statut === 'disponible' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($vehicule->statut) }}
                  </span>
                </td>
                <td>
                  <div class="btn-group" role="group">
                    <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="btn btn-warning btn-sm">
                      <i class="fas fa-edit"></i> Modifier
                    </a>
                    <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce véhicule ?')">
                        <i class="fas fa-trash"></i> Supprimer
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="text-center py-5">
          <i class="fas fa-car text-muted" style="font-size: 3rem;"></i>
          <p class="mt-3 text-muted">Aucun véhicule trouvé.</p>
          <a href="{{ route('vehicules.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter le premier véhicule
          </a>
        </div>
      @endif
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
=======
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
>>>>>>> 986648c4e6d6fbef9359283de0742967b8d0e04c
