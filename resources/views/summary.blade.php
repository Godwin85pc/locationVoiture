<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { 
      background: #e9f0f8; 
      font-family: 'Arial', Helvetica, sans-serif; 
    }
    .card { 
      max-width: 800px; 
      margin: 110px auto; /* centrage vertical légèrement vers le haut */
      border-radius: 20px; 
      box-shadow: 0 6px 25px rgba(0,0,0,0.2);
    }
    .card-header { 
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      font-size: 1.2rem;
    }
    .btn-outline-primary, .btn-outline-success, .btn-outline-warning, .btn-outline-danger {
      border-radius: 15px;
      font-weight: 500;
      min-width: 150px;
    }
    .btn-outline-primary:hover { background-color: #d0e1ff; }
    .btn-outline-success:hover { background-color: #d4f1d4; }
    .btn-outline-warning:hover { background-color: #fff3d4; }
    .btn-outline-danger:hover { background-color: #f8d4d4; }
    
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

  <div class="container d-flex justify-content-center">
    <div class="card shadow-lg w-100">
      <div class="card-header bg-primary text-white text-center">
        <h4>Résumé du véhicule</h4>
      </div>
      <div class="card-body text-center">
        <h5>Nom du véhicule : Toyota</h5>
        <p>Immatriculation : AB-123-CD</p>
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-3">
           <!-- Bouton Modifie0r les infos -->
          <a href="{{ url('1-ajout_voiture') }}" class="btn btn-outline-primary">Modifier les infos</a>
          <!-- Autres boutons restent inchangés -->
          <button class="btn btn-outline-success">Ajouter des photos</button>
          <button class="btn btn-outline-warning">Mettre à jour calendrier</button>
          <!-- Bouton Valider l’annonce -->
          <a href="{{ url('connection') }}" class="btn btn-outline-danger">Valider l’annonce</a>
        </div>
        </div>
      </div>
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
