<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validation entretien</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Police et taille uniforme */
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5); /* bleu clair / léger */
      color: #333;
    }
   .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1); /* rend les 3 barres blanches */
      width: 2rem;
      height: 2rem;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .btn-custom, .btn-success, .btn-danger {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      border-radius: 30px;
    }

    .btn-custom {
      background: #6aa0e5;
      color: white;
    }

    .btn-custom:hover {
      background: #4f86d1;
    }

    .btn-success {
      background: #6aa0e5;
      border-color: #6aa0e5;
    }

    .btn-success:hover {
      background: #4f86d1;
      border-color: #4f86d1;
    }

    .btn-danger {
      background: #e57373;
      border-color: #e57373;
    }

    .btn-danger:hover {
      background: #d45f5f;
      border-color: #d45f5f;
    }

    h3 {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 22px;
    }

    p {
      font-size: 16px;
    }
  </style>
</head>
<body>
   <!-- Barre de navigation -->
  <nav class="navbar navbar-light bg-primary px-3">
    <!-- Nom du site -->
    <a class="navbar-brand text-white" href="#">MonSite</a>

    <!-- Bouton hamburger à droite -->
    <div class="dropdown ms-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ url('01-ajout_voiture') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <div class="container d-flex justify-content-center align-items-center my-5" style="min-height:50vh;">
     @csrf 
    <div class="card p-5 w-50 text-center">
      <h3 class="mb-4 text-primary"><i class="fa-solid fa-screwdriver-wrench"></i> Entretien du véhicule</h3>
      <p>Veuillez confirmer si votre véhicule est <strong>bien entretenu</strong>.</p>
      <button id="ouiBtn" class="btn btn-success w-100 mb-3"><i class="fa-solid fa-check"></i> Oui</button>
      <button id="nonBtn" class="btn btn-danger w-100"><i class="fa-solid fa-xmark"></i> Non</button>
    </div>
  </div>

  <script>
    // Redirection selon le choix
    document.getElementById('ouiBtn').addEventListener('click', () => {
      window.location.href = "{{ route('prix') }}"; // Page suivante si Oui
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

