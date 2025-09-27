<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Résultats de recherche - LocationVoiture</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- CSS personnalisé -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <style>
    .navbar-toggler { border: none; }
    .navbar-toggler-icon { filter: invert(1); width: 2rem; height: 2rem; }
  </style>
</head>
<body>


  <!-- Barre de navigation -->
  <nav class="navbar navbar-light bg-primary px-3">
    <!-- Nom du site -->
    <a class="navbar-brand text-white" href="{{ url('/') }}">MonSite</a>

    <!-- Bouton hamburger à droite -->
    <div class="dropdown ms-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <!-- route() remplacé par url() -->
        <li><a class="dropdown-item" href="{{ url('/login') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="#">Questions</a></li>
      </ul>
    </div>
  </nav>

<!-- Résumé de la recherche -->
<div class="container mt-4">
  <div class="search-summary">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h5>Votre recherche</h5>
        <p class="mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> <strong>Lieu de récupération:</strong> <span id="pickup-location">Paris Gare du Nord</span></p>
        <p class="mb-0"><i class="fas fa-calendar-alt text-primary me-1"></i> <strong>Date de récupération:</strong> <span id="pickup-date">21/09/2025 à 10:00</span></p>
        <p class="mb-0"><i class="fas fa-map-marker-alt text-primary me-1"></i> <strong>Lieu de retour:</strong> <span id="return-location">Paris Gare du Nord</span></p>
        <p class="mb-0"><i class="fas fa-calendar-alt text-primary me-1"></i> <strong>Date de retour:</strong> <span id="return-date">25/09/2025 à 10:00</span></p>
        <p class="mb-0 mt-2"><i class="fas fa-user text-primary me-1"></i> <strong>Conducteur:</strong> <span id="driver-age">Entre 25 et 30 ans</span></p>
      </div>
      <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <button class="btn btn-outline-primary" onclick="window.history.back()"><i class="fas fa-edit me-1"></i> Modifier la recherche</button>
      </div>
    </div>
  </div>

  <!-- Filtres et résultats -->
  <div class="row mt-4">
    <!-- Filtres -->
    <div class="col-lg-3">
      <div class="filter-section">
        <h5 class="section-title">Filtres</h5>

        <div class="mb-4">
          <h6>Catégorie de véhicule</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="city-car" checked><label class="form-check-label" for="city-car">Citadine</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="compact" checked><label class="form-check-label" for="compact">Compacte</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="sedan" checked><label class="form-check-label" for="sedan">Berline</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="suv" checked><label class="form-check-label" for="suv">SUV</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="minivan" checked><label class="form-check-label" for="minivan">Monospace</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="utility" checked><label class="form-check-label" for="utility">Utilitaire</label></div>
        </div>

        <div class="mb-4">
          <h6>Prix par jour</h6>
          <input type="range" class="form-range" id="priceRange" min="20" max="200" value="200">
          <div class="d-flex justify-content-between"><span>20€</span><span id="max-price">200€</span></div>
        </div>

        <div class="mb-4">
          <h6>Carburant</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="essence" checked><label class="form-check-label" for="essence">Essence</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="diesel" checked><label class="form-check-label" for="diesel">Diesel</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="electric" checked><label class="form-check-label" for="electric">Électrique</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="hybrid" checked><label class="form-check-label" for="hybrid">Hybride</label></div>
        </div>

        <div class="mb-4">
          <h6>Transmission</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="manual" checked><label class="form-check-label" for="manual">Manuelle</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="automatic" checked><label class="form-check-label" for="automatic">Automatique</label></div>
        </div>

        <div class="mb-4">
          <h6>Disponibilité</h6>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="available" checked><label class="form-check-label" for="available">Disponible</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="reserved"><label class="form-check-label" for="reserved">Réservé</label></div>
          <div class="form-check"><input class="form-check-input" type="checkbox" id="rented"><label class="form-check-label" for="rented">Loué</label></div>
        </div>

        <button class="btn btn-primary w-100" onclick="applyFilters()">Appliquer les filtres</button>
      </div>
    </div>

    <!-- Résultats -->
    <div class="col-lg-9">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0"><span id="vehicles-count">0</span> véhicules disponibles</h4>
        <div>
          <select class="form-select" id="sort-options">
            <option value="relevance" selected>Trier par: Pertinence</option>
            <option value="price-asc">Prix: croissant</option>
            <option value="price-desc">Prix: décroissant</option>
            <option value="category">Catégorie</option>
          </select>
        </div>
      </div>

      <div id="vehicles-container"></div>
    </div>
  </div>
</div>

<!-- Footer noir -->
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

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- JS personnalisé -->
<script src="{{ asset('js/voiture.js') }}"></script>

</body>
</html>
