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

      <form>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-building"></i> Marque</label>
            <input type="text" class="form-control" placeholder="Ex: Toyota" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-car"></i> Modèle</label>
            <input type="text" class="form-control" placeholder="Ex: Corolla" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-hashtag"></i> Immatriculation</label>
            <input type="text" class="form-control" placeholder="Ex: AB-123-CD" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-calendar"></i> Année</label>
            <input type="number" class="form-control" placeholder="Ex: 2020" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gas-pump"></i> Carburant</label>
            <select class="form-select" required>
              <option value="">-- Choisir --</option>
              <option>Essence</option>
              <option>Diesel</option>
              <option>Hybride</option>
              <option>Électrique</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gears"></i> Boîte de vitesse</label>
            <select class="form-select" required>
              <option value="">-- Choisir --</option>
              <option>Manuelle</option>
              <option>Automatique</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-users"></i> Nombre de places</label>
            <input type="number" class="form-control" placeholder="Ex: 5" required>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gauge-high"></i> Kilométrage</label>
            <input type="number" class="form-control" placeholder="Ex: 50000" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><i class="fa-solid fa-clipboard-list"></i> Description</label>
          <textarea class="form-control" rows="3" placeholder="Décrivez brièvement votre véhicule..." required></textarea>
        </div>

        <!-- BOUTON = LIEN -->
        <a href="{{ url('resources\views\02-options_extras') }}" class="btn btn-custom w-100">
          <i class="fa-solid fa-arrow-right"></i> Suivant
        </a>
      </form>
    </div>
  </div>
</body>
</html>
