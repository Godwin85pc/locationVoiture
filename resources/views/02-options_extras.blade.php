<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Options supplémentaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5);
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
      font-size: 16px;
    }
    .btn-custom:hover {
      background: #4f86d1;
    }
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1);
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
        <li><a class="dropdown-item" href="{{ url('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ url('connection') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card p-5 w-75">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-sliders"></i> Options supplémentaires
      </h3>

      <!-- ✅ FORMULAIRE AVEC PROTECTION CSRF -->
      <form id="optionsForm">
        @csrf  <!-- 🔹 Protection CSRF ici, PAS dans le footer -->

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="gps" name="gps">
            <label class="form-check-label" for="gps"><i class="fa-solid fa-map"></i> GPS</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="siegebebe" name="siegebebe">
            <label class="form-check-label" for="siegebebe"><i class="fa-solid fa-baby-carriage"></i> Siège bébé</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="coffre" name="coffre">
            <label class="form-check-label" for="coffre"><i class="fa-solid fa-box"></i> Coffre de toit</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="portevelos" name="portevelos">
            <label class="form-check-label" for="portevelos"><i class="fa-solid fa-bicycle"></i> Porte-vélos</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="pneus" name="pneus">
            <label class="form-check-label" for="pneus"><i class="fa-solid fa-snowflake"></i> Pneus neige</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="bluetooth" name="bluetooth">
            <label class="form-check-label" for="bluetooth"><i class="fa-solid fa-music"></i> Audio Bluetooth</label>
          </div>
        </div>

        <a href="{{ url('03-maintenance') }}"><button  type="button" class="btn btn-custom w-100"><i class="fa-solid fa-arrow-right"></i> Suivant
        </button> </a>
          
      </form>
      <!-- ✅ FIN DU FORMULAIRE -->
    </div>
  </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
