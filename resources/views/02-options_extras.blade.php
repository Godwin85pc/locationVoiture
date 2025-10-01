<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Options supplémentaires</title>
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

    .form-check-label i {
      color: #6aa0e5;
      margin-right: 5px;
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

    .form-check-label {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
    }
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
        <i class="fa-solid fa-sliders"></i> Options supplémentaires
      </h3>
      <form id="optionsForm">
        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="gps">
            <label class="form-check-label" for="gps"><i class="fa-solid fa-map"></i> GPS</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="siegebebe">
            <label class="form-check-label" for="siegebebe"><i class="fa-solid fa-baby-carriage"></i> Siège bébé</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="coffre">
            <label class="form-check-label" for="coffre"><i class="fa-solid fa-box"></i> Coffre de toit</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="portevelos">
            <label class="form-check-label" for="portevelos"><i class="fa-solid fa-bicycle"></i> Porte-vélos</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="pneus">
            <label class="form-check-label" for="pneus"><i class="fa-solid fa-snowflake"></i> Pneus neige</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="bluetooth">
            <label class="form-check-label" for="bluetooth"><i class="fa-solid fa-music"></i> Audio Bluetooth</label>
          </div>
        </div>

        <button type="submit" class="btn btn-custom w-100">
          <i class="fa-solid fa-arrow-right"></i> Suivant
        </button>
      </form>
    </div>
  </div>

  <script>
    const form = document.getElementById('optionsForm');
    form.addEventListener('submit', function(e) {
      e.preventDefault(); // empêche le rechargement de page
      // Redirection vers la page suivante
      window.location.href ="{{ url('03-maintenance') }}";
    });
  </script>
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

