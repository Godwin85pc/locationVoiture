<!DOCTYPE html>
<html lang="fr">
<head>
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
            <li><a class="dropdown-item" href="{{ route('voiture2') }}">Nos véhicules</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <!-- Bouton retour -->
    <a href="{{ route('voiture2') }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Retour aux véhicules
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

                    <h4 class="text-success">{{ $vehicule->prix_jour }} €/jour</h4>
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
                            <i class="fas fa-tag me-2 text-primary"></i> 
                            <strong>Type :</strong> {{ $vehicule->type }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-id-card me-2 text-primary"></i> 
                            <strong>Immatriculation :</strong> {{ $vehicule->immatriculation }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-gas-pump me-2 text-primary"></i> 
                            <strong>Carburant :</strong> {{ $vehicule->carburant }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-users me-2 text-primary"></i> 
                            <strong>Nombre de places :</strong> {{ $vehicule->nbre_places }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-map-marker-alt me-2 text-primary"></i> 
                            <strong>Localisation :</strong> {{ $vehicule->localisation }}
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-tachometer-alt me-2 text-primary"></i> 
                            <strong>Kilométrage :</strong> {{ number_format($vehicule->kilometrage) }} km
                        </li>
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
</body>
</html>