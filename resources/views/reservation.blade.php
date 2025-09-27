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

    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">

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
    <!-- Contenu principal -->
    <div class="container mt-4 flex-grow-1">
        <div class="row">
            <!-- Formulaire -->
            <div class="col-lg-8">
                <div class="card reservation-card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Formulaire de réservation et d'inscription</h4>
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
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birthDate" class="form-label">Date de naissance *</label>
                                    <input type="text" class="form-control" id="birthDate" placeholder="mm/aaaa" required>
                                    <div class="error-message" id="birthDate-error"></div>
                                </div>
                                <div class="col-md-6 mb-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="address" class="form-label">Adresse *</label>
                                    <input type="text" class="form-control" id="address" required>
                                    <div class="error-message" id="address-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="postalCode" class="form-label">Code postal *</label>
                                    <input type="text" class="form-control" id="postalCode" required>
                                    <div class="error-message" id="postalCode-error"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="city" class="form-label">Ville *</label>
                                    <input type="text" class="form-control" id="city" required>
                                    <div class="error-message" id="city-error"></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="country" class="form-label">Pays *</label>
                                    <select class="form-select" id="country" required>
                                        <option value="" selected disabled>Sélectionnez un pays</option>
                                        <option value="france">France</option>
                                        <option value="belgique">Belgique</option>
                                        <option value="suisse">Suisse</option>
                                        <option value="luxembourg">Luxembourg</option>
                                    </select>
                                    <div class="error-message" id="country-error"></div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Création du compte -->
                            <h5 class="section-title mb-4">Création de votre compte</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Mot de passe *</label>
                                    <input type="password" class="form-control" id="password" required>
                                    <div class="error-message" id="password-error"></div>
                                    <div class="password-strength" id="password-strength"></div>
                                    <small class="form-text text-muted">Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre.</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmation du mot de passe *</label>
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                    <div class="error-message" id="confirmPassword-error"></div>
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
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Type de carte</label>
                                    <div class="d-flex mt-2">
                                        <i class="fab fa-cc-visa fa-2x me-2 text-primary"></i>
                                        <i class="fab fa-cc-mastercard fa-2x me-2 text-danger"></i>
                                        <i class="fab fa-cc-amex fa-2x text-info"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Conditions générales avec accordéon -->
                            <h5 class="section-title mb-4">Conditions générales</h5>
                            <div class="accordion mb-4" id="accordionConditions">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingConditions">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConditions" aria-expanded="false" aria-controls="collapseConditions">
                                            Politique de confidentialité et conditions d'utilisation
                                        </button>
                                    </h2>
                                    <div id="collapseConditions" class="accordion-collapse collapse" aria-labelledby="headingConditions" data-bs-parent="#accordionConditions">
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
            <!-- Récapitulatif -->
            <div class="col-lg-4">
                <div class="card summary-card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-primary">Récapitulatif de votre réservation</h5>
                    </div>
                    <div class="card-body">
                        <!-- Véhicule sélectionné -->
                        <div class="summary-section mb-4">
                            <h6 class="text-primary mb-3">Véhicule sélectionné</h6>
                            <div class="d-flex align-items-center">
                                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=60" 
                                     alt="PEUGEOT 208" class="vehicle-thumbnail me-3">
                                <div>
                                    <strong class="d-block">PEUGEOT 208</strong>
                                    <small class="text-muted">Citadine - Automatique</small>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Pack sélectionné -->
                        <div class="summary-section mb-4">
                            <h6 class="text-primary mb-3">Pack sélectionné</h6>
                            <div class="pack-summary">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <strong>PACK PREMIUM</strong>
                                    <span class="pack-price">175€</span>
                                </div>
                                <div class="pack-features">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Responsabilité civile</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Assurance tous risques</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <small>Remboursement des franchises avec Allianz</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Dates et lieux -->
                        <div class="summary-section mb-4">
                            <h6 class="text-primary mb-3">Dates et lieux</h6>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Récupération</strong>
                                    <div class="mt-1">
                                        <div>21/09/2025 à 10:00</div>
                                        <small class="text-muted">Paris Gare du Nord</small>
                                    </div>
                                </div>
                                <div class="col-6 text-end">
                                    <strong>Retour</strong>
                                    <div class="mt-1">
                                        <div>25/09/2025 à 10:00</div>
                                        <small class="text-muted">Paris Gare du Nord</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Détail du prix -->
                        <div class="summary-section mb-4">
                            <h6 class="text-primary mb-3">Détail du prix</h6>
                            <div class="price-details">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Location (4 jours)</span>
                                    <span>140€</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Pack assurance</span>
                                    <span>35€</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Frais de service</span>
                                    <span>10€</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <!-- Total TTC -->
                        <div class="summary-section">
                            <div class="d-flex justify-content-between align-items-center total-price">
                                <h6 class="text-primary mb-0">Total TTC</h6>
                                <strong class="text-primary" style="font-size: 1.4rem;">185€</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Assistance -->
                <div class="card mt-4">
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
                    <div class="d-flex">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                    </div>
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
                    <p>Abonnez-vous pour recevoir nos offres exclusives</p>
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

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Ton JS personnalisé -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>