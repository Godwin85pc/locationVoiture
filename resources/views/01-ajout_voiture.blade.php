
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informations véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Police et taille uniforme */
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5); /* bleu clair léger */
      color: #333;
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .form-control, .form-select {
      border-radius: 10px;
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
    }

    .btn-custom {
      background: #6aa0e5;
      color: white;
      border-radius: 30px;
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
    }

    .btn-custom:hover {
      background: #4f86d1;
    }

    label i {
      color: #6aa0e5;
      margin-right: 5px;
    }

    .invalid-feedback { display: none; }
    .is-invalid + .invalid-feedback { display: block; }

    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1); /* rend les 3 barres blanches */
      width: 2rem;
      height: 2rem;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-light" style="background-color:#6aa0e5;">
    <a class="navbar-brand text-white" href="#">MonSite</a>
    <div class="dropdown ms-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item"  href="{{ url('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ url('connection')}}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card p-5 w-75">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-car-side"></i> Informations du véhicule
      </h3>

      <form id="vehicleForm">
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-building"></i> Marque</label>
            <input type="text" class="form-control" placeholder="Ex: Toyota" required>
            <div class="invalid-feedback">Veuillez entrer la marque du véhicule.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-car"></i> Modèle</label>
            <input type="text" class="form-control" placeholder="Ex: Corolla" required>
            <div class="invalid-feedback">Veuillez entrer le modèle du véhicule.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-hashtag"></i> Immatriculation</label>
            <input type="text" class="form-control" placeholder="Ex: AB-123-CD" required>
            <div class="invalid-feedback">Veuillez entrer l'immatriculation.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-calendar"></i> Année</label>
            <input type="number" class="form-control" placeholder="Ex: 2020" required>
            <div class="invalid-feedback">Veuillez entrer l'année du véhicule.</div>
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
            <div class="invalid-feedback">Veuillez sélectionner un type de carburant.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gears"></i> Boîte de vitesse</label>
            <select class="form-select" required>
              <option value="">-- Choisir --</option>
              <option>Manuelle</option>
              <option>Automatique</option>
            </select>
            <div class="invalid-feedback">Veuillez sélectionner la boîte de vitesse.</div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-users"></i> Nombre de places</label>
            <input type="number" class="form-control" placeholder="Ex: 5" required>
            <div class="invalid-feedback">Veuillez entrer le nombre de places.</div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gauge-high"></i> Kilométrage</label>
            <input type="number" class="form-control" placeholder="Ex: 50000" required>
            <div class="invalid-feedback">Veuillez entrer le kilométrage.</div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label"><i class="fa-solid fa-clipboard-list"></i> Description</label>
          <textarea class="form-control" rows="3" placeholder="Décrivez brièvement votre véhicule..." required></textarea>
          <div class="invalid-feedback">Veuillez entrer une description.</div>
        </div>

        <button type="submit" class="btn btn-custom w-100">
          <i class="fa-solid fa-arrow-right"></i> Suivant
        </button>
      </form>
    </div>
  </div>

  <script>
    const form = document.getElementById('vehicleForm');

    form.addEventListener('submit', function(e){
      e.preventDefault();
      let valid = true;

      const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
      inputs.forEach(input => {
        if(!input.value.trim()){
          valid = false;
          input.classList.add('is-invalid');
        } else {
          input.classList.remove('is-invalid');
        }
      });

      if(valid){
        window.location.href ="{{ url('02-options_extras') }}";
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <footer class="mt-5 bg-dark text-white">
  <div class="container py-5">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>LocationVoiture</h5>
        <p>Le meilleur choix pour votre location de véhicule.</p>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>Contact</h5>
        <p>123 Avenue de Paris, France</p>
        <p>+33 1 23 45 67 89</p>
        <p>info@locationvoiture.fr</p>
      </div>
      <div class="col-md-4">
        <h5>Newsletter</h5>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Votre email">
          <button class="btn btn-primary">S'abonner</button>
        </div>
      </div>
    </div>
    <hr class="bg-light">
    <div class="text-center">&copy; 2025 LocationVoiture. Tous droits réservés.</div>
  </div>
</footer>

<!-- Modal détails -->
<div class="modal fade" id="vehicleDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Détails du véhicule</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="vehicleDetailsContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>


