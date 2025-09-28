<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>page d'acceuil</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <li><a class="dropdown-item" href="{{ route('connection') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ route('01-ajout_voiture') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <style>
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1); /* rend les 3 barres blanches */
      width: 2rem;
      height: 2rem;
    }
  </style>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <div class="container mt-5">
    <div class="mx-auto fw-bold fs-2 text-center" style="max-width: 800px">
      Partez à l’aventure avec la voiture qu’il vous faut – réservation rapide,
      conduite tranquille.
    </div>
  </div>

  <div class="container d-flex justify-content-center mt-5">
    <div class="p-4 rounded bg-light w-100" style="max-width: 600px">
      <!-- Lieu de récupération -->
      <h5 class="mb-2">Lieu de récupération du véhicule :</h5>
      <div class="mb-4">
        <input type="text" class="form-control" placeholder="Entrez le lieu de récupération" />
      </div>

      <!-- Heure de sollicitation -->
      <h5 class="mb-2">Sollicitation du véhicule :</h5>
      <div class="row mb-4">
        <div class="col">
          <label for="dateDepart" class="form-label">Date</label>
          <input type="date" class="form-control" id="dateDepart" />
        </div>
        <div class="col">
          <label for="heureDepart" class="form-label">Heure</label>
          <input type="time" class="form-control" id="heureDepart" />
        </div>
      </div>

      <!-- Lieu de retour -->
      <h5 class="mb-2">Lieu de retour du véhicule :</h5>
      <div class="mb-4">
        <input type="text" class="form-control" placeholder="Entrez le lieu de retour" />
      </div>

      <!-- Retour du véhicule -->
      <h5 class="mb-2">Retour du véhicule :</h5>
      <div class="row mb-4">
        <div class="col">
          <label for="dateRetour" class="form-label">Date</label>
          <input type="date" class="form-control" id="dateRetour" />
        </div>
        <div class="col">
          <label for="heureRetour" class="form-label">Heure</label>
          <input type="time" class="form-control" id="heureRetour" />
        </div>
      </div>

      <!-- Checkbox -->
      <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="ageCheck" />
        <label class="form-check-label" for="ageCheck">
          Conducteur entre 25 et 30 ans
        </label>
      </div>

      <!-- Lien client fidèle -->
      <p>
        <a href="#" class="text-decoration-underline">Êtes-vous client fidèle ?</a>
      </p>

      <!-- Bouton Rechercher -->
      <div class="text-center mt-4">
        <button type="submit" class="btn btn-primary">Rechercher</button>
      </div>
    </div>
  </div>

  <footer class="bg-dark text-white py-3 mt-5">
    <div class="container d-flex justify-content-between align-items-start flex-wrap" style="gap: 1rem">
      <!-- Infos à gauche -->
      <div class="pe-3">
        <p class="mb-1"><strong>AutoLocation+</strong></p>
        <p class="mb-1">123 Rue de la Location</p>
        <p class="mb-0">Ville, Pays</p>
      </div>

      <!-- Infos à droite -->
      <div class="text-end ps-3">
        <p class="mb-1"><strong>Tél :</strong> +33 6 12 34 56 78</p>
        <p class="mb-0"><strong>Email :</strong> contact@autolocation.com</p>
      </div>
    </div>
  </footer>
</body>
</html>
