<!DOCTYPE html>
<html lang="fr">
<head>
<<<<<<< HEAD
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails du véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #6a11cb, #2575fc); }
    .card { border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
    .info-label { font-weight: bold; color: #2575fc; }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="card p-4">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-car-side"></i> Détails du véhicule
      </h3>

      <div class="row">
        <div class="col-md-6">
          @if($vehicule->photo)
            <img src="{{ $vehicule->photo }}" alt="Photo du véhicule" class="img-fluid rounded mb-3">
          @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
              <i class="fas fa-car text-muted" style="font-size: 3rem;"></i>
            </div>
          @endif
        </div>
        <div class="col-md-6">
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Marque:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->marque }}
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Modèle:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->modele }}
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Type:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->type }}
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Immatriculation:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->immatriculation }}
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Prix par jour:</span>
            </div>
            <div class="col-sm-8">
              <strong class="text-success">{{ $vehicule->prix_jour }}€</strong>
            </div>
          </div>
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Carburant:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->carburant }}
            </div>
          </div>
          
          @if($vehicule->nbre_places)
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Nombre de places:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->nbre_places }}
            </div>
          </div>
          @endif
          
          @if($vehicule->kilometrage)
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Kilométrage:</span>
            </div>
            <div class="col-sm-8">
              {{ number_format($vehicule->kilometrage) }} km
            </div>
          </div>
          @endif
          
          @if($vehicule->localisation)
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Localisation:</span>
            </div>
            <div class="col-sm-8">
              {{ $vehicule->localisation }}
            </div>
          </div>
          @endif
          
          <div class="row mb-3">
            <div class="col-sm-4">
              <span class="info-label">Statut:</span>
            </div>
            <div class="col-sm-8">
              <span class="badge {{ $vehicule->statut === 'disponible' ? 'bg-success' : 'bg-warning' }}">
                {{ ucfirst($vehicule->statut) }}
              </span>
            </div>
          </div>
        </div>
      </div>
      
      @if($vehicule->description)
      <div class="row mt-4">
        <div class="col-12">
          <h5 class="info-label">Description:</h5>
          <p class="text-muted">{{ $vehicule->description }}</p>
        </div>
      </div>
      @endif

      <div class="d-flex gap-3 mt-4">
        @auth
          @if(auth()->id() === $vehicule->proprietaire_id)
            <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="btn btn-warning">
              <i class="fas fa-edit"></i> Modifier
            </a>
          @endif
        @endauth
        
        @if($vehicule->statut === 'disponible')
          <a href="{{ route('reservations.create', $vehicule->id) }}" class="btn btn-primary">
            <i class="fas fa-calendar-plus"></i> Réserver
          </a>
        @endif
        
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Retour
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vehicule->marque }} {{ $vehicule->modele }} - Détails</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body { 
            background-color: #f9f9f9; 
            padding-top: 70px;
        }
        .vehicle-image { 
            width: 100%; 
            height: 400px; 
            object-fit: cover; 
            border-radius: 10px;
        }
        .card-avis {
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }
        .star-rating {
            color: #ffc107;
        }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-light bg-primary px-3 fixed-top">
    <a class="navbar-brand text-white" href="{{ route('index') }}">MonSite</a>
    <div class="dropdown ms-auto">
        <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            @auth
                <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Se déconnecter</button>
                    </form>
                </li>
            @else
                <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
                <li><a class="dropdown-item" href="{{ route('register') }}">S'inscrire</a></li>
            @endauth
                        <li><a class="dropdown-item" href="{{ route('vehicules.index') }}">Nos véhicules</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <!-- Bouton retour -->
    <a href="{{ route('vehicules.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour
    </a>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Image et infos principales -->
        <div class="col-md-6">
            <img src="{{ $vehicule->photo ?? 'https://via.placeholder.com/400x400?text=Véhicule' }}" 
                 alt="{{ $vehicule->marque }}" 
                 class="vehicle-image shadow">
            
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-primary">
                        {{ $vehicule->marque }} {{ $vehicule->modele }}
                    </h3>
                    <p class="text-muted">{{ ucfirst($vehicule->type) }}</p>
                    
                    @php
                        $noteMoyenne = $vehicule->avis->avg('note') ?? 0;
                        $nombreAvis = $vehicule->avis->count();
                    @endphp
                    
                    <div class="mb-3">
                        <strong>Note moyenne :</strong>
                        <span class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $noteMoyenne)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="text-muted">
                            ({{ number_format($noteMoyenne, 1) }}/5 - {{ $nombreAvis }} avis)
                        </span>
                    </div>

                    <h4 class="text-success">{{ $vehicule->prix_par_jour ?? $vehicule->prix_jour }} €/jour</h4>
                    
                    <!-- Bouton Réserver -->
                    @auth
                        <a href="{{ route('reservations.create', $vehicule->id) }}" class="btn btn-primary mt-3">
                            <i class="bi bi-calendar-plus"></i> Réserver ce véhicule
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary mt-3">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter pour réserver
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Caractéristiques détaillées -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Caractéristiques</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-cog me-2 text-primary"></i> 
                            <strong>Marque :</strong> {{ $vehicule->marque }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-car me-2 text-primary"></i> 
                            <strong>Modèle :</strong> {{ $vehicule->modele }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-calendar me-2 text-primary"></i> 
                            <strong>Année :</strong> {{ $vehicule->annee }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-id-card me-2 text-primary"></i> 
                            <strong>Plaque :</strong> {{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-gas-pump me-2 text-primary"></i> 
                            <strong>Carburant :</strong> {{ $vehicule->carburant }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-cogs me-2 text-primary"></i> 
                            <strong>Transmission :</strong> {{ $vehicule->transmission }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-users me-2 text-primary"></i> 
                            <strong>Places :</strong> {{ $vehicule->nombre_places ?? $vehicule->nbre_places }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i> 
                            <strong>Localisation :</strong> {{ $vehicule->localisation }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-palette me-2 text-primary"></i> 
                            <strong>Couleur :</strong> {{ $vehicule->couleur }}
                        </li>
                        @if($vehicule->climatisation)
                            <li class="list-group-item">
                                <i class="fas fa-snowflake me-2 text-success"></i> 
                                <strong>Climatisation</strong>
                            </li>
                        @endif
                        @if($vehicule->gps)
                            <li class="list-group-item">
                                <i class="fas fa-location-arrow me-2 text-success"></i> 
                                <strong>GPS inclus</strong>
                            </li>
                        @endif
                    </ul>

                    @if($vehicule->description)
                        <div class="mt-3">
                            <h6><strong>Description :</strong></h6>
                            <p class="text-muted">{{ $vehicule->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Section Avis -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-chat-dots"></i> Avis des clients ({{ $nombreAvis }})</h5>
                </div>
                <div class="card-body">
                    
                    <!-- Formulaire pour laisser un avis -->
                    @auth
                        <div class="mb-4 p-3 bg-light rounded">
                            <h6 class="mb-3">Laissez votre avis</h6>
                            <form action="{{ route('avis.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Votre note :</label>
                                    <select name="note" class="form-select" required>
                                        <option value="">Sélectionnez une note</option>
                                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                        <option value="4">⭐⭐⭐⭐ Très bien</option>
                                        <option value="3">⭐⭐⭐ Bien</option>
                                        <option value="2">⭐⭐ Moyen</option>
                                        <option value="1">⭐ Mauvais</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Votre commentaire (optionnel) :</label>
                                    <textarea name="commentaire" class="form-control" rows="3" 
                                              placeholder="Partagez votre expérience..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> Publier mon avis
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis sur ce véhicule.
                        </div>
                    @endauth

                    <!-- Liste des avis -->
                    @forelse($vehicule->avis as $avis)
                        <div class="card card-avis">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <i class="bi bi-person-circle"></i> 
                                            {{ $avis->utilisateur->name ?? 'Utilisateur' }}
                                        </h6>
                                        <div class="star-rating mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $avis->note)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                            <span class="text-muted ms-2">{{ $avis->note }}/5</span>
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        {{ $avis->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                @if($avis->commentaire)
                                    <p class="mb-0 mt-2">{{ $avis->commentaire }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">
                            <i class="bi bi-chat-left-text"></i> Aucun avis pour le moment. 
                            Soyez le premier à donner votre avis !
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-5 py-4">
    <div class="container text-center">
        <p class="mb-0">&copy; 2025 LocationVoiture. Tous droits réservés.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
>>>>>>> 986648c4e6d6fbef9359283de0742967b8d0e04c
</body>
</html>