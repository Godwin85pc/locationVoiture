<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos véhicules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f9f9f9; }
        .vehicle-card { border-radius: 10px; overflow: hidden; border: 1px solid #ddd; transition: transform .2s; }
        .vehicle-card:hover { transform: scale(1.02); }
        .vehicle-image { width: 100%; height: 200px; object-fit: cover; }
        .btn-reserver { background-color: #007bff; color: white; font-weight: 600; }
    </style>
</head>
<body>

<!-- Barre de navigation -->
<nav class="navbar navbar-light bg-primary px-3">
    <a class="navbar-brand text-white" href="#">MonSite</a>
    <div class="dropdown ms-auto">
        <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('connection') }}">Se connecter</a></li>
            <li><a class="dropdown-item" href="#">À propos</a></li>
            <li><a class="dropdown-item" href="{{ route('01-ajout_voiture') }}">Louer ma voiture</a></li>
        </ul>
    </div>
</nav>

<!-- Résumé de la recherche -->
<div class="container mt-4">
    <div class="bg-white p-4 rounded shadow-sm">
        <h5 class="mb-3">Récapitulatif de votre recherche</h5>
        <div class="row">
            <div class="col-md-6"><strong>Lieu de départ :</strong> {{ request('lieuRecup', 'Non spécifié') }}</div>
            <div class="col-md-6"><strong>Lieu de retour :</strong> {{ request('lieuRetour', 'Non spécifié') }}</div>
            <div class="col-md-6"><strong>Date de départ :</strong> {{ request('dateDepart', 'Non spécifiée') }}</div>
            <div class="col-md-6"><strong>Date de retour :</strong> {{ request('dateRetour', 'Non spécifiée') }}</div>
            <div class="col-md-6"><strong>Âge du conducteur :</strong> {{ request('ageCheck', 'Non spécifié') }}</div>
            <div class="col-md-6"><strong>Véhicules trouvés :</strong> {{ $vehicules->count() }}</div>
        </div>
    </div>

     <!-- Bouton Rechercher -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                <i class="bi bi-search"></i> Modifier la rechercher
            </button>
</div>

<!-- Liste des véhicules -->
<div class="container mt-5">
    <div class="row">
        @forelse($vehicules as $vehicule)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card vehicle-card">
                    <!-- Image -->
                    <img src="{{ $vehicule->photo }}" 
                         alt="{{ $vehicule->marque }}" class="vehicle-image">

                    <!-- Corps -->
                    <div class="card-body">
                        <h5>{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                        <p class="text-muted">{{ ucfirst($vehicule->type) }}</p>

                        <!-- Note moyenne -->
                        @php $noteMoyenne = $vehicule->avis->avg('note') ?? 0; @endphp
                        <p><strong>Note moyenne :</strong> 
                            @if($noteMoyenne > 0)
                                {{ number_format($noteMoyenne, 1) }}/5
                            @else
                                <span class="text-muted">Aucune note</span>
                            @endif
                        </p>

                        <!-- Caractéristiques principales -->
                        <div class="vehicle-specs mb-3">
                            <p><i class="fas fa-cog me-2"></i> marque: {{ $vehicule->marque}}</p>
                            <p><i class="fas fa-snowflake me-2"></i> modele: {{ $vehicule->modele }}</p>
                            <p><i class="fas fa-car me-2"></i> type: {{ $vehicule->type}}</p>
                            <p><i class="fas fa-users me-2"></i> immatriculation: {{ $vehicule->immatriculation }}</p>
                            <p><i class="fas fa-road me-2"></i> prix_jour: {{ $vehicule->prix_jour }} </p>
                            <p><i class="fas fa-gas-pump me-2"></i>statut: {{ $vehicule->statut}}</p>
                            <p><i class="fas fa-tachomerter-alt me-2"><i> carburant:{{$vehicule->carburant}}</i>
                            <p><i class="fas fa-cogs me-2"></i>nbre_places: {{ $vehicule->nbre_places}}</p>
                            <p><i class="fas fa-ruler-horizontal me-2"></i> localisation: {{ $vehicule->localisation}}</p>
                            <p><i class="fas fa-calendar-alt me-2"></i> kilometrage: {{ $vehicule->kilometrage}}</p>
                            <p>
                            

    
                            @if(!empty($vehicule->features))
                                @foreach($vehicule->features as $feature)
                                    <p><i class="fas fa-check text-success me-2"></i> {{ $feature }}</p>
                                @endforeach
                            @endif
                        </div>

                        <!-- Packs avec accordéon -->
                        @php
                            $packs = is_string($vehicule->packs) ? json_decode($vehicule->packs, true) : $vehicule->packs;
                        @endphp
                            @if(!empty($vehicule->packs))

    <div class="accordion" id="accordion{{ $vehicule->id }}">
        @foreach($packs as $index => $pack)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $vehicule->id }}{{ $index }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#collapse{{ $vehicule->id }}{{ $index }}" 
                            aria-expanded="false" aria-controls="collapse{{ $vehicule->id }}{{ $index }}">
                        {{ $pack['name'] ?? 'Pack' }} - {{ $pack['price'] ?? '?' }}{{ $pack['currency'] ?? '€' }}
                    </button>
                </h2>
                <div id="collapse{{ $vehicule->id }}{{ $index }}" class="accordion-collapse collapse" 
                     aria-labelledby="heading{{ $vehicule->id }}{{ $index }}" data-bs-parent="#accordion{{ $vehicule->id }}">
                    <div class="accordion-body">
                        @if(!empty($pack['features']))
                            <ul>
                                @foreach($pack['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Aucune information sur ce pack</p>
                        @endif
                        <a href="{{ route('reservation', ['id' => $vehicule->id, 'pack' => $pack['name']]) }}" 
                           class="btn btn-sm btn-reserver">Réserver</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

                        <!-- Avis des clients -->
                        <a href="{{ route('vehicules.show', $vehicule->id) }}" class="btn btn-outline-primary btn-sm">
                            Voir détails + avis
                        </a>

                        <!-- Formulaire de notation -->
                        @auth
                            <form action="{{ route('avis.store') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">
                                <div class="d-flex align-items-center mb-2">
                                    <label class="me-2">Votre note :</label>
                                    <select name="note" class="form-select form-select-sm" style="width:auto;">
                                        @for($i=1; $i<=5; $i++)
                                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success ms-2">Noter</button>
                                </div>
                            </form>
                        @else
                            <p class="text-muted mt-2">Connectez-vous pour noter ce véhicule.</p>
                        @endauth

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted mt-5">
                Aucun véhicule trouvé pour cette recherche.
            </div>
        @endforelse
    </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-auto">
  <div class="container py-4">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>LocationVoiture</h5>
        <p>Le meilleur choix pour votre location de véhicule. Confort, sécurité et prix compétitifs garantis.</p>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>Contactez-nous</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue de Paris, France</li>
          <li><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</li>
          <li><i class="fas fa-envelope me-2"></i> info@locationvoiture.fr</li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Newsletter</h5>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Votre email">
          <button class="btn btn-primary">S'abonner</button>
        </div>
      </div>
    </div>
    <hr class="my-4 bg-light">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 LocationVoiture. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
