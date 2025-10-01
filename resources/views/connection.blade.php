<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      font-size: 17px;
      background: linear-gradient(to right, #36d1dc, #5b86e5);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
      padding-top: 80px;   /* pour compenser le header */
    }

    main {
      flex: 1; /* pousse le footer vers le bas */
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    /* Header fixé */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 1100;
    }

    /* Footer normal (pas fixé) */
    footer {
      background: #222;
      color: white;
    }

    .form-container {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
      max-width: 400px;
      width: 100%;
    }
    h3 {
      font-weight: bold;
      color: #5b86e5;
    }
    label {
      font-weight: 500;
    }
    .btn-primary {
      background: #5b86e5;
      border: none;
      border-radius: 25px;
      padding: 10px;
      font-size: 16px;
    }
    .btn-primary:hover {
      background: #36d1dc;
    }
    a {
      color: #5b86e5;
      text-decoration: underline;
    }
    a:hover {
      color: #36d1dc;
      text-decoration: none;
    }
    p {
      font-size: 15px;
    }
    .btn-success, .btn-warning {
      border-radius: 25px;
      font-weight: 500;
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
        <li><a class="dropdown-item" href="{{ url('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ url('01-ajout_voiture') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main>
    <div class="form-container">
      <!-- Formulaire de connexion -->
      <div id="formConnexion">
        <h3 class="text-center mb-4">Connexion</h3>
        <form>
          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" placeholder="nom@example.com" required />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" placeholder="Votre mot de passe" required />
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Se connecter</button>
          </div>

          <p class="text-center mb-1">
            Si vous n'êtes pas encore inscrit <a href="{{ url('inscrit') }}">Cliquez ici</a>
          </p>
          <p class="text-center mb-0">
            Mot de passe oublié ? <a href="#">Cliquez ici</a>
          </p>
        </form>
      </div>

      <!-- Formulaire avec choix après connexion -->
      <div id="formChoix" style="display: none;">
        <h3 class="text-center mb-4">Que souhaitez-vous faire ?</h3>
        <div class="d-grid gap-3">
          <button class="btn btn-success" onclick="location.href='{{ route('01-ajout_voiture') }}'">Louer ma voiture</button>
          <button class="btn btn-warning" onclick="location.href='{{ route('index') }}'">Louer une voiture</button>
        </div>
      </div>
    </div>
  </main>

  <!-- Script pour gérer la connexion -->
  <script>
    document.querySelector('#formConnexion form').addEventListener('submit', function(event) {
      event.preventDefault(); 
      document.getElementById('formConnexion').style.display = 'none';
      document.getElementById('formChoix').style.display = 'block';
    });
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <footer class="bg-dark text-white">
    <div class="container py-4">
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
