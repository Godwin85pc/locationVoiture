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
        .vehicle-card { border-radius: 10px; overflow: hidden; border: 1px solid #ddd; transition: transform .2s; background-color: #fff; }
        .vehicle-card:hover { transform: scale(1.02); }
        .vehicle-image { width: 100%; height: 200px; object-fit: cover; }
        .btn-reserver { background-color: #007bff; color: white; font-weight: 600; }
        .recap { background-color: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .recap .row > div { margin-bottom: 10px; }
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
            <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
            <li><a class="dropdown-item" href="#">À propos</a></li>
            <li><a class="dropdown-item" href="{{ route('vehicules.create') }}">Louer ma voiture</a></li>
        </ul>
    </div>
</nav>

<!-- Résumé de la recherche -->
  <div class="container mt-4">
    <div class="recap">
        <h5 class="mb-3">Récapitulatif de votre recherche</h5>
        <div class="row">
            <div class="col-md-6">
                <strong>Lieu de départ :</strong> 
                {{ $searchData['lieuRecup'] ?? 'Non spécifié' }}
            </div>
            <div class="col-md-6">
                <strong>Lieu de retour :</strong> 
                {{ $searchData['lieuRetour'] ?? 'Non spécifié' }}
            </div>
            <div class="col-md-6">
                <strong>Date de départ :</strong> 
                @if(isset($searchData['dateDepart']))
                    {{ \Carbon\Carbon::parse($searchData['dateDepart'])->format('d/m/Y') }}
                    @if(isset($searchData['heureDepart']))
                        à {{ $searchData['heureDepart'] }}
                    @endif
                @else
                    Non spécifiée
                @endif
            </div>
            <div class="col-md-6">
                <strong>Date de retour :</strong> 
                @if(isset($searchData['dateRetour']))
                    {{ \Carbon\Carbon::parse($searchData['dateRetour'])->format('d/m/Y') }}
                    @if(isset($searchData['heureRetour']))
                        à {{ $searchData['heureRetour'] }}
                    @endif
                @else
                    Non spécifiée
                @endif
            </div>
            <div class="col-md-6">
                <strong>Véhicules trouvés :</strong> {{ $vehicules->count() }}
            </div>
        </div>

        <!-- Bouton Modifier la recherche -->
        <div class="d-flex justify-content-center mt-3">
            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-5 shadow">
                <i class="bi bi-search"></i> Modifier la recherche
            </a>
        </div>
    </div>
</div>
<!-- Liste des véhicules -->
<div class="container mt-5">
    <div class="row">
        @forelse($vehicules as $vehicule)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card vehicle-card">
                    <!-- Image -->
                <img src="{{ $vehicule->photo_url }}" 
                         alt="{{ $vehicule->marque }}" class="vehicle-image">

                    <!-- Corps -->
                    <div class="card-body">
                        <h5>{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                        <p class="text-muted">{{ ucfirst($vehicule->type) }}</p>

                        <!-- Note moyenne sécurisée -->
                        @php
                            $noteMoyenne = optional($vehicule->avis)->avg('note') ?? 0;
                        @endphp
                        <p><strong>Note moyenne :</strong> 
                            @if($noteMoyenne > 0)
                                {{ number_format($noteMoyenne, 1) }}/5
                            @else
                                <span class="text-muted">Aucune note</span>
                            @endif
                        </p>

                        <!-- Caractéristiques principales -->
                        <div class="vehicle-specs mb-3">
                            <p><i class="fas fa-cog me-2"></i> Marque: {{ $vehicule->marque}}</p>
                            <p><i class="fas fa-snowflake me-2"></i> Modèle: {{ $vehicule->modele }}</p>
                            <p><i class="fas fa-car me-2"></i> Type: {{ $vehicule->type}}</p>
                            <p><i class="fas fa-users me-2"></i> Immatriculation: {{ $vehicule->immatriculation }}</p>
                            <p><i class="fas fa-road me-2"></i> Prix/jour: {{ $vehicule->prix_jour }} €</p>
                            <p><i class="fas fa-gas-pump me-2"></i> Carburant: {{ $vehicule->carburant }}</p>
                            <p><i class="fas fa-cogs me-2"></i> Nombre de places: {{ $vehicule->nbre_places}}</p>
                            <p><i class="fas fa-ruler-horizontal me-2"></i> Localisation: {{ $vehicule->localisation}}</p>
                            <p><i class="fas fa-calendar-alt me-2"></i> Kilométrage: {{ $vehicule->kilometrage}} km</p>
                        </div>

                        @php
                            // Calculer le nombre de jours
                            $dateDepart = $searchData['dateDepart'] ?? null;
                            $dateRetour = $searchData['dateRetour'] ?? null;
                            $nombreJours = 1;
                            
                            if ($dateDepart && $dateRetour) {
                                $debut = \Carbon\Carbon::parse($dateDepart);
                                $fin = \Carbon\Carbon::parse($dateRetour);
                                $nombreJours = max(1, $debut->diffInDays($fin));
                            }
                            
                            // Calcul des prix
                            $prixJour = $vehicule->prix_jour;
                            $prixStandard = $prixJour * $nombreJours;
                            $prixPremium = $prixStandard * 1.20; // +20%
                        @endphp

                        <!-- PACK STANDARD -->
                        <div class="card mb-3 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-box"></i> PACK STANDARD</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-3">
                                    <li><i class="fas fa-check text-success"></i> Responsabilité civile</li>
                                    <li><i class="fas fa-check text-success"></i> Assurance tous risques avec franchise</li>
                                    <li><i class="fas fa-check text-success"></i> {{ number_format($nombreJours * 750) }} Kilomètres inclus</li>
                                    <li><i class="fas fa-check text-success"></i> Annulation gratuite</li>
                                </ul>
                                
                                <div class="text-center mb-3">
                                    <p class="mb-1">
                                        <span class="badge bg-info">{{ $nombreJours }} jour(s)</span>
                                    </p>
                                    <h4 class="text-primary mb-0">
                                        {{ number_format($prixStandard, 2) }} €
                                    </h4>
                                    <small class="text-muted">({{ $prixJour }} €/jour)</small>
                                </div>
                                
                                <a href="{{ route('reservation.create', ['vehicule_id' => $vehicule->id, 'pack' => 'standard', 'prix' => $prixStandard, 'nombre_jours' => $nombreJours]) }}" 
                                   class="btn btn-primary w-100">
                                    <i class="fas fa-calendar-check"></i> RÉSERVER
                                </a>
                            </div>
                        </div>

                        <!-- PACK PREMIUM -->
                        <div class="card mb-3 border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0"><i class="fas fa-crown"></i> PACK PREMIUM</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-3">
                                    <li><i class="fas fa-check text-success"></i> Responsabilité civile</li>
                                    <li><i class="fas fa-check text-success"></i> Assurance tous risques</li>
                                    <li><i class="fas fa-check text-success"></i> <strong>Remboursement des franchises avec Allianz</strong></li>
                                    <li><i class="fas fa-check text-success"></i> {{ number_format($nombreJours * 1000) }} Kilomètres inclus</li>
                                    <li><i class="fas fa-check text-success"></i> Annulation gratuite</li>
                                    <li><i class="fas fa-check text-success"></i> GPS inclus</li>
                                    <li><i class="fas fa-check text-success"></i> Conducteur additionnel gratuit</li>
                                </ul>
                                
                                <div class="text-center mb-3">
                                    <p class="mb-1">
                                        <span class="badge bg-info">{{ $nombreJours }} jour(s)</span>
                                        <span class="badge bg-success">+20%</span>
                                    </p>
                                    <h4 class="text-warning mb-0">
                                        {{ number_format($prixPremium, 2) }} €
                                    </h4>
                                    <small class="text-muted">({{ number_format($prixPremium / $nombreJours, 2) }} €/jour)</small>
                                </div>
                                
                                <a href="{{ route('reservation.create', ['vehicule_id' => $vehicule->id, 'pack' => 'premium', 'prix' => $prixPremium, 'nombre_jours' => $nombreJours]) }}" 
                                   class="btn btn-warning w-100 text-dark">
                                    <i class="fas fa-crown"></i> RÉSERVER
                                </a>
                            </div>
                        </div>

                        <!-- Avis des clients -->
                        <a href="{{ route('vehicules.show', $vehicule->id) }}" class="btn btn-outline-primary btn-sm mt-2 w-100">
                            <i class="fas fa-info-circle"></i> Voir détails + avis
                        </a>

                        <!-- Formulaire de notation -->
                        @auth
                            <form action="{{ route('avis.store') }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">
                                <div class="d-flex align-items-center mb-2">
                                    <label class="me-2 small">Votre note :</label>
                                    <select name="note" class="form-select form-select-sm" style="width:auto;">
                                        @for($i=1; $i<=5; $i++)
                                            <option value="{{ $i }}">{{ $i }} ⭐</option>
                                        @endfor
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-success ms-2">Noter</button>
                                </div>
                            </form>
                        @else
                            <p class="text-muted mt-2 small text-center">Connectez-vous pour noter ce véhicule.</p>
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
<footer class="bg-dark text-white mt-5">
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