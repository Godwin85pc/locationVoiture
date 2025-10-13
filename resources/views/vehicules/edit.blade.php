<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Modifier le véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #6a11cb, #2575fc); }
    .card { border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
    .form-control, .form-select { border-radius: 10px; }
    .btn-custom { background: #2575fc; color: white; border-radius: 30px; text-align: center; text-decoration: none; display: inline-block; padding: 10px; }
    .btn-custom:hover { background: #6a11cb; color: #fff; }
    label i { color: #2575fc; margin-right: 5px; }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card p-5 w-75">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-car-side"></i> Modifier le véhicule
      </h3>

      <form action="{{ route('vehicules.update', $vehicule->id) }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
        @csrf
        @method('PUT')
        
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-building"></i> Marque</label>
            <input type="text" name="marque" class="form-control" placeholder="Ex: Toyota" value="{{ old('marque', $vehicule->marque) }}" required>
            <div class="invalid-feedback">Veuillez entrer la marque du véhicule.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-car"></i> Modèle</label>
            <input type="text" name="modele" class="form-control" placeholder="Ex: Corolla" value="{{ old('modele', $vehicule->modele) }}" required>
            <div class="invalid-feedback">Veuillez entrer le modèle du véhicule.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-tag"></i> Type</label>
            <select name="type" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="SUV" {{ old('type', $vehicule->type) == 'SUV' ? 'selected' : '' }}>SUV</option>
              <option value="Berline" {{ old('type', $vehicule->type) == 'Berline' ? 'selected' : '' }}>Berline</option>
              <option value="Utilitaire" {{ old('type', $vehicule->type) == 'Utilitaire' ? 'selected' : '' }}>Utilitaire</option>
              <option value="Citadine" {{ old('type', $vehicule->type) == 'Citadine' ? 'selected' : '' }}>Citadine</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner un type.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-hash"></i> Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control" placeholder="Ex: AB-123-CD" value="{{ old('immatriculation', $vehicule->immatriculation) }}" required>
            <div class="invalid-feedback">Veuillez entrer l'immatriculation.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-currency-euro"></i> Prix par jour (€)</label>
            <input type="number" name="prix_jour" class="form-control" placeholder="Ex: 50" step="0.01" value="{{ old('prix_jour', $vehicule->prix_jour) }}" required>
            <div class="invalid-feedback">Veuillez entrer le prix par jour.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-fuel-pump"></i> Carburant</label>
            <select name="carburant" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="Essence" {{ old('carburant', $vehicule->carburant) == 'Essence' ? 'selected' : '' }}>Essence</option>
              <option value="Diesel" {{ old('carburant', $vehicule->carburant) == 'Diesel' ? 'selected' : '' }}>Diesel</option>
              <option value="Electrique" {{ old('carburant', $vehicule->carburant) == 'Electrique' ? 'selected' : '' }}>Électrique</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner un type de carburant.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-people"></i> Nombre de places</label>
            <input type="number" name="nbre_places" class="form-control" placeholder="Ex: 5" value="{{ old('nbre_places', $vehicule->nbre_places) }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-speedometer"></i> Kilométrage</label>
            <input type="number" name="kilometrage" class="form-control" placeholder="Ex: 50000" value="{{ old('kilometrage', $vehicule->kilometrage) }}">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-geo-alt"></i> Localisation</label>
            <input type="text" name="localisation" class="form-control" placeholder="Ex: Paris" value="{{ old('localisation', $vehicule->localisation) }}">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-image"></i> URL Photo</label>
            <input type="url" name="photo" class="form-control" placeholder="https://..." value="{{ old('photo', $vehicule->photo) }}">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><i class="bi bi-card-text"></i> Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Décrivez brièvement votre véhicule...">{{ old('description', $vehicule->description) }}</textarea>
        </div>

        <div class="d-flex gap-3">
          <button type="submit" class="btn btn-primary flex-fill">
            <i class="bi bi-check-circle"></i> Modifier le véhicule
          </button>
          <a href="{{ route('dashboard') }}" class="btn btn-secondary flex-fill">
            <i class="bi bi-arrow-left"></i> Annuler
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Affichage des erreurs de validation -->
  @if ($errors->any())
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
      <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
  @endif

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>