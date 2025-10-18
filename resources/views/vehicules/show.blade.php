<!DOCTYPE html>
<html lang="fr">
<head>
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
</body>
</html>