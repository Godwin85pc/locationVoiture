<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prix dynamiques</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding-top: 70px; /* espace pour le header fixe */
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.25);
      width: 100%;
      max-width: 700px;
      padding: 30px;
    }

    .price-box {
      background: white;
      padding: 15px;
      border-radius: 15px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .btn-circle {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      font-weight: bold;
      display: inline-flex;
      justify-content: center;
      align-items: center;
    }

    .btn-plus { background: #28a745; color: white; border: none; }
    .btn-minus { background: #dc3545; color: white; border: none; }
    .btn-plus:hover { background: #218838; }
    .btn-minus:hover { background: #c82333; }

    .btn-custom {
      background: #6aa0e5;
      color: white;
      border-radius: 30px;
      font-size: 16px;
      border: none;
    }

    .btn-custom:hover { background: #4f86d1; }

    .radio-label { cursor: pointer; }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1030;
    }

    footer {
      margin-top: auto;
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
  <!-- Barre de navigation -->
  <nav class="navbar navbar-light bg-primary px-3">
    <a class="navbar-brand text-white" href="#">MonSite</a>
    <div class="dropdown ms-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ route('01-ajout_voiture') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contenu principal -->
  <div class="container d-flex justify-content-center my-5">
    <div class="card shadow-lg">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-chart-line"></i> Fixer les prix dynamiques
      </h3>

      <form id="priceForm" method="POST" action="{{ route('vehicules.step4') }}">
        @csrf
        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="14"> 
            <i class="fa-solid fa-calendar-day"></i> Faible (Semaine scolaire) : <b class="price">14</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="19"> 
            <i class="fa-solid fa-calendar-week"></i> Moyenne (Week-end scolaire) : <b class="price">19</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="35"> 
            <i class="fa-solid fa-sun"></i> Forte (Vacances scolaires) : <b class="price">35</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="48"> 
            <i class="fa-solid fa-umbrella-beach"></i> Très forte (Été - Juillet/Août) : <b class="price">48</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <!-- Bouton de confirmation redirige via Laravel -->
        <div class="mb-3">
          <label class="form-label">Prix retenu (€)</label>
          <input type="number" name="prix_par_jour" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-custom w-100 mt-3">
          <i class="fa-solid fa-check"></i> Enregistrer le prix et confirmer
        </button>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white">
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
