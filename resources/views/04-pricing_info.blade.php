<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5); /* bleu clair léger */
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .card {
      max-width: 700px;
      width: 100%;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
       margin: 80px auto; /
    }

    .card-header {
      border-radius: 20px 20px 0 0;
      background-color: #6aa0e5;
      color: white;
      font-size: 18px;
      text-align: center;
    }

    .form-label, .form-control, p {
      font-size: 16px;
    }

    .form-control {
      border-radius: 10px;
    }

    .btn-custom, .btn-success {
      background: #6aa0e5;
      color: white;
      border-radius: 30px;
      font-size: 16px;
    }

    .btn-custom:hover, .btn-success:hover {
      background: #4f86d1;
    }

    /* Contenu centré mais avec espace pour le footer */
    .content {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
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
        <li><a class="dropdown-item" href="{{ url('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ url('01-ajout_voiture') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contenu principal -->
  <div class="content" class="container d-flex justify-content-center align-items-center my-5" style="min-height:50vh;">
    <div class="card shadow-lg">
      <div class="card-header">
        <h4>Définissez vos prix</h4>
      </div>
      <div class="card-body">
        <p>
          Vous définissez un prix par jour. Nous calculons le prix de réservation basé sur vos tarifs 
          et incluons les frais d’assurance. Nous déduisons <b>10% de frais de service</b>. 
          Vous êtes indemnisé pour les frais supplémentaires (carburant manquant, pénalités...).
        </p>
        <form action="{{ route('05-set_prices') }}">
          <div class="mb-3">
            <label class="form-label">Prix par jour (€)</label>
            <input type="number" class="form-control" placeholder="Ex: 30">
          </div>
          <button type="submit" class="btn btn-custom w-100">Fixer les prix de location</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white">
    <div class="container py-4">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5>LocationVoiture</h5>
          <p>Le meilleur choix pour votre location de véhicule.</p>
        </div>
        <div class="col-md-4 mb-3">
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
</body>
</html>
