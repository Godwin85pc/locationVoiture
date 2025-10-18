<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informations véhicule</title>
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
        <i class="fa-solid fa-car-side"></i> Informations du véhicule
      </h3>

      <form action="{{ route('vehicules.store') }}" method="POST" enctype="multipart/form-data" id="vehicleForm">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-building"></i> Marque</label>
            <input type="text" name="marque" class="form-control" placeholder="Ex: Toyota" required>
            <div class="invalid-feedback">Veuillez entrer la marque du véhicule.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-car"></i> Modèle</label>
            <input type="text" name="modele" class="form-control" placeholder="Ex: Corolla" required>
            <div class="invalid-feedback">Veuillez entrer le modèle du véhicule.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-tag"></i> Type</label>
            <select name="type" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="SUV">SUV</option>
              <option value="Berline">Berline</option>
              <option value="Utilitaire">Utilitaire</option>
              <option value="Citadine">Citadine</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner un type.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-hash"></i> Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control" placeholder="Ex: AB-123-CD" required>
            <div class="invalid-feedback">Veuillez entrer l'immatriculation.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-currency-euro"></i> Prix par jour (€)</label>
            <input type="number" name="prix_jour" class="form-control" placeholder="Ex: 50" step="0.01" required>
            <div class="invalid-feedback">Veuillez entrer le prix par jour.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-fuel-pump"></i> Carburant</label>
            <select name="carburant" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="Essence">Essence</option>
              <option value="Diesel">Diesel</option>
              <option value="Electrique">Électrique</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner un type de carburant.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-people"></i> Nombre de places</label>
            <input type="number" name="nbre_places" class="form-control" placeholder="Ex: 5">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-speedometer"></i> Kilométrage</label>
            <input type="number" name="kilometrage" class="form-control" placeholder="Ex: 50000">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-geo-alt"></i> Localisation</label>
            <input type="text" name="localisation" class="form-control" placeholder="Ex: Paris">
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-image"></i> URL Photo</label>
            <input type="url" name="photo" class="form-control" placeholder="https://...">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><i class="bi bi-card-text"></i> Description</label>
          <textarea name="description" class="form-control" rows="3" placeholder="Décrivez brièvement votre véhicule..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-plus-circle"></i> Ajouter le véhicule
        </button>
      </form>
    </div>
  </div>
</body>
</html>
