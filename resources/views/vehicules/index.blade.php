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