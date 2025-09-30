<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Réservation - Location de Véhicules</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    :root {
      --primary-color: #0d6efd;
      --secondary-color: #6c757d;
      --accent-color: #fd7e14;
    }

    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
    }

    /* Header */
    .navbar {
      background-color: var(--primary-color);
    }
    .navbar .navbar-brand, .navbar .dropdown-toggle, .navbar a.text-white {
      color: white;
    }
    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1);
      width: 2rem;
      height: 2rem;
    }

    /* Formulaire réservation */
    .reservation-card, .summary-card {
      border: none;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,.08);
      background-color: white;
    }

    .section-title {
      border-bottom: 2px solid var(--primary-color);
      padding-bottom: 10px;
      margin-bottom: 20px;
      color: #333;
    }

    .btn-reserve {
      background-color: var(--accent-color);
      border: none;
      padding: 10px 20px;
      font-weight: 600;
      color: white;
      width: 100%;
      cursor: pointer;
    }

    .btn-reserve:hover {
      background-color: #e76c02;
    }

    /* Footer */
    footer {
      background-color: #000;
      color: white;
      padding: 40px 0;
      margin-top: auto;
    }
    footer a {
      color: white;
    }

    .error-message {
      color: red;
      font-size: 0.9rem;
      margin-top: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .row > [class*='col-'] {
        margin-bottom: 15px;
      }
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100">

<!-- Header -->
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
<div class="container mt-4 flex-grow-1 d-flex flex-column">
  <div class="row flex-grow-1">
    <!-- Formulaire -->
    <div class="col-lg-8 mb-4">
      <div class="card reservation-card h-100">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Formulaire de réservation</h4>
        </div>
        <div class="card-body">
          <form id="reservation-form" novalidate>
            <!-- Informations personnelles -->
            <h5 class="section-title mb-4">Informations personnelles</h5>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="lastName" class="form-label">Nom *</label>
                <input type="text" class="form-control" id="lastName" required>
                <div class="error-message" id="lastName-error"></div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="firstName" class="form-label">Prénom *</label>
                <input type="text" class="form-control" id="firstName" required>
                <div class="error-message" id="firstName-error"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" required>
                <div class="error-message" id="email-error"></div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Téléphone *</label>
                <input type="tel" class="form-control" id="phone" required>
                <div class="error-message" id="phone-error"></div>
              </div>
            </div>

            <hr class="my-4">

            <!-- Informations de paiement -->
            <h5 class="section-title mb-4">Informations de paiement</h5>
            <div class="row">
              <div class="col-12 mb-3">
                <label for="cardholder" class="form-label">Titulaire de la carte *</label>
                <input type="text" class="form-control" id="cardholder" required>
                <div class="error-message" id="cardholder-error"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <label for="cardNumber" class="form-label">Numéro de carte *</label>
                <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                <div class="error-message" id="cardNumber-error"></div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="expiryDate" class="form-label">Date d'expiration *</label>
                <input type="text" class="form-control" id="expiryDate" placeholder="MM/AA" required>
                <div class="error-message" id="expiryDate-error"></div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="cvv" class="form-label">CVV *</label>
                <input type="text" class="form-control" id="cvv" placeholder="123" required>
                <div class="error-message" id="cvv-error"></div>
              </div>
            </div>

            <!-- Conditions générales -->
            <h5 class="section-title mb-4">Conditions générales</h5>
            <div class="accordion mb-4" id="accordionConditions">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingConditions">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                          data-bs-target="#collapseConditions" aria-expanded="false" aria-controls="collapseConditions">
                    Politique de confidentialité et conditions d'utilisation
                  </button>
                </h2>
                <div id="collapseConditions" class="accordion-collapse collapse"
                     aria-labelledby="headingConditions" data-bs-parent="#accordionConditions">
                  <div class="accordion-body">
                    <p>En cochant la case ci-dessous, vous acceptez les conditions générales de location et la politique de confidentialité de LocationVoiture.</p>
                    <h6>Données personnelles</h6>
                    <p>Les informations recueillies sur ce formulaire sont enregistrées dans un fichier informatisé par LocationVoiture pour la gestion des réservations et la relation client. Elles sont conservées pendant 3 ans et sont destinées au service commercial.</p>
                    <h6>Conditions de location</h6>
                    <p>Le véhicule doit être rendu dans l'état où il a été remis. Tout dommage constaté au retour du véhicule sera facturé selon le barème en vigueur. Le carburant est à la charge du locataire.</p>
                    <h6>Paiement et caution</h6>
                    <p>Une pré-autorisation de 1000€ sera demandée sur votre carte de crédit comme caution. Cette somme sera libérée dans les 7 jours après la restitution du véhicule, sous réserve qu'aucun dommage ne soit constaté.</p>
                    <h6>Annulation</h6>
                    <p>En cas d'annulation plus de 48h avant le début de la location, aucun frais ne sera retenu. Entre 48h et 24h avant, 50% du montant total sera facturé. Moins de 24h avant, la totalité de la location sera due.</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-check mb-4">
              <input class="form-check-input" type="checkbox" id="terms" required>
              <label class="form-check-label" for="terms">
                J'accepte les conditions générales de location et la politique de confidentialité *
              </label>
              <div class="error-message" id="terms-error"></div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100">
              <i class="fas fa-check-circle me-2"></i>Confirmer la réservation et le paiement
            </button>
          </form>
        </div>
      </div>
    </div>

    <!-- Colonne droite : Récapitulatif + Assistance -->
    <div class="col-lg-4 d-flex flex-column">
      <!-- Récapitulatif -->
      <div class="card summary-card mb-4 flex-grow-1">
        <div class="card-header bg-light">
          <h5 class="mb-0 text-primary">Récapitulatif de votre réservation</h5>
        </div>
        <div class="card-body" id="reservation-summary">
          <p>Les informations de votre réservation apparaîtront ici.</p>
        </div>
      </div>

      <!-- Assistance -->
      <div class="card">
        <div class="card-body text-center">
          <i class="fas fa-headset fa-2x text-primary mb-3"></i>
          <h6 class="text-primary">Besoin d'aide ?</h6>
          <p class="text-muted mb-3">Notre équipe est à votre disposition</p>
          <div class="d-flex flex-column align-items-center">
            <p class="mb-1">
              <i class="fas fa-phone me-2 text-primary"></i>+33 1 23 45 67 89
            </p>
            <p class="mb-0">
              <i class="fas fa-envelope me-2 text-primary"></i>support@locationvoiture.fr
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white mt-auto">
  <div class="container py-4">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>LocationVoiture</h5>
        <p>Le meilleur choix pour votre location de véhicule. Confort, sécurité et prix compétitifs garantis.</p>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <h5>Contactez-nous</h5>
        <ul class="list-unstyled">
          <li><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue de Paris, France</li>
          <li><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</li>
          <li><i class="fas fa-envelope me-2"></i> info@locationvoiture.fr</li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Newsletter</h5>
        <div class="input-group">
          <input type="email" class="form-control" placeholder="Votre email">
          <button class="btn btn-primary">S'abonner</button>
        </div>
      </div>
    </div>
    <hr class="my-4 bg-light">
    <div class="text-center">
      <p class="mb-0">&copy; 2025 LocationVoiture. Tous droits réservés.</p>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const form = document.getElementById('reservation-form');
  const summary = document.getElementById('reservation-summary');

  form.addEventListener('submit', function(e){
    e.preventDefault();
    let valid = true;

    const requiredFields = [
      'lastName','firstName','email','phone',
      'cardholder','cardNumber','expiryDate','cvv','terms'
    ];

    requiredFields.forEach(id => {
      const field = document.getElementById(id);
      const error = document.getElementById(id+'-error');
      if(!field.checkValidity()){
        error.textContent = 'Ce champ est obligatoire';
        valid = false;
      } else { error.textContent = ''; }
    });

    if(valid){
      summary.innerHTML = `
        <p><strong>Nom:</strong> ${document.getElementById('lastName').value}</p>
        <p><strong>Prénom:</strong> ${document.getElementById('firstName').value}</p>
        <p><strong>Email:</strong> ${document.getElementById('email').value}</p>
        <p><strong>Téléphone:</strong> ${document.getElementById('phone').value}</p>
        <p><strong>Carte:</strong> ${document.getElementById('cardholder').value} - ${document.getElementById('cardNumber').value}</p>
      `;
      alert('Réservation validée !');
    }
  });
</script>

</body>
</html>
