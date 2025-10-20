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
        <div class="d-flex flex-wrap gap-2">
          <!-- Bouton Modifie0r les infos -->
          <a href="{{ route('vehicules.create') }}" class="btn btn-outline-primary">Modifier les infos</a>
          <!-- Autres boutons restent inchangés -->
          <button class="btn btn-outline-success">Ajouter des photos</button>
          <button class="btn btn-outline-warning">Mettre à jour calendrier</button>
          <!-- Validation de l’annonce -->
          @auth
            <form action="{{ route('vehicules.step5') }}" method="POST" class="d-inline">
              @csrf
                <button type="submit" class="btn btn-outline-success">Valider l’annonce</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="btn btn-outline-danger">Se connecter pour valider</a>
          @endauth
        </div>
      </div>
    </div>
  </div>
</body>
</html>
