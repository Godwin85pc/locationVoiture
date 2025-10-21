<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation - {{ $vehicule->marque }} {{ $vehicule->modele }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #0d6efd; --accent-color: #fd7e14; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin:0; padding:0;}
        .navbar { background-color: var(--primary-color);}
        .navbar .navbar-brand, .navbar .dropdown-toggle, .navbar a.text-white { color: white; }
        .navbar-toggler { border: none; }
        .navbar-toggler-icon { filter: invert(1); width: 2rem; height: 2rem; }
        .card { border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); background-color:white;}
        .section-title { border-bottom: 2px solid var(--primary-color); padding-bottom: 10px; margin-bottom: 20px; color: #333; }
        .btn-reserve { background-color: var(--accent-color); border: none; padding: 10px 20px; font-weight: 600; color: white; width: 100%; cursor: pointer;}
        .btn-reserve:hover { background-color: #e76c02; }
        .error-message { color:red; font-size:0.9rem; margin-top:5px; }
        footer { background-color:#000; color:white; padding:40px 0; margin-top:auto; }
        footer a { color:white; }
        @media (max-width:768px) { .row > [class*='col-'] { margin-bottom:15px; } }
        .pack-badge { position:absolute; top:10px; right:10px; font-size:0.9rem; padding:5px 15px;}
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
            <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
            <li><a class="dropdown-item" href="#">À propos</a></li>
            <li><a class="dropdown-item" href="{{ route('vehicules.create') }}">Louer ma voiture</a></li>
        </ul>
    </div>
</nav>

<!-- Contenu principal -->
<div class="container mt-4 flex-grow-1 d-flex flex-column">
    <div class="row flex-grow-1">
        <!-- Colonne gauche : Véhicule + récapitulatif -->
        <div class="col-lg-4 mb-4">
            <div class="card position-relative">
                <span class="badge pack-badge {{ $pack === 'premium' ? 'bg-warning text-dark' : 'bg-primary' }}">
                    @if($pack === 'premium') 
                        <i class="fas fa-crown"></i> Premium 
                    @else 
                        <i class="fas fa-box"></i> Standard 
                    @endif
                </span>
                <img src="{{ $vehicule->photo_url }}" class="card-img-top" alt="{{ $vehicule->marque }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-car text-primary"></i> Année: {{ $vehicule->annee ?? 'Non spécifiée' }}</li>
                        <li><i class="fas fa-gas-pump text-primary"></i> {{ $vehicule->carburant ?? 'Non spécifié' }}</li>
                        <li><i class="fas fa-users text-primary"></i> {{ $vehicule->nombre_places ?? $vehicule->nbre_places ?? 'Non spécifié' }} places</li>
                        <li><i class="fas fa-map-marker-alt text-primary"></i> {{ $vehicule->localisation ?? 'Non spécifiée' }}</li>
                    </ul>
                    <hr>
                    <div class="text-center">
                        <h6>Récapitulatif</h6>
                        <p class="mb-1"><strong>Durée :</strong> {{ $nombreJours }} jour(s)</p>
                        <p class="mb-1"><strong>Pack :</strong> {{ ucfirst($pack) }}</p>
                        <h4 class="text-primary mt-3"><strong>{{ number_format($prix,2) }} €</strong></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite : Formulaire -->
        <div class="col-lg-8 mb-4">
            <div class="card reservation-card h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulaire de réservation</h4>
                </div>
                <div class="card-body">
                    <form id="reservation-form" action="{{ route('reservations.store') }}" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="vehicule_id" value="{{ $vehicule->id }}">
                        <input type="hidden" name="pack" value="{{ $pack }}">
                        <input type="hidden" name="prix_total" value="{{ $prix }}">
                        <input type="hidden" name="statut" value="en_attente">

                        <!-- Informations personnelles -->
                        <h5 class="section-title mb-4">Informations personnelles</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Nom *</label>
                                <input type="text" name="nom" id="lastName" class="form-control" value="{{ Auth::user()->name ?? '' }}" required>
                                <div class="error-message" id="lastName-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Prénom *</label>
                                <input type="text" name="prenom" id="firstName" class="form-control"  value="{{ Auth::user()->prenom ?? '' }}"  required>
                                <div class="error-message" id="firstName-error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email ?? '' }}" required>
                                <div class="error-message" id="email-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Téléphone *</label>
                                <input type="tel" name="telephone" id="phone" class="form-control" placeholder="+33 6 12 34 56 78" required>
                                <div class="error-message" id="phone-error"></div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <h5 class="section-title mb-4">Dates de réservation</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début *</label>
                                <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ session('recherche.dateDepart') }}" required>
                                <div class="error-message" id="date_debut-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_fin" class="form-label">Date de fin *</label>
                                <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ session('recherche.dateRetour') }}" required>
                                <div class="error-message" id="date_fin-error"></div>
                            </div>
                        </div>

                        <!-- Lieux -->
                        <h5 class="section-title mb-4">Lieux de prise et restitution</h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="lieu_recuperation" class="form-label">Lieu de récupération *</label>
                                <input type="text" name="lieu_recuperation" id="lieu_recuperation" class="form-control" value=" {{ session('recherche.lieu_recuperation') }}" required>
                                <div class="error-message" id="lieu_recuperation-error"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lieu_restitution" class="form-label">Lieu de restitution *</label>
                                <input type="text" name="lieu_restitution" id="lieu_restitution" class="form-control" value="{{ session('recherche.lieu_restitution') }}" required>
                                <div class="error-message" id="lieu_restitution-error"></div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Informations paiement -->
                        <h5 class="section-title mb-2">Informations de paiement</h5>
                        <p class="text-muted">Ces informations ne seront pas enregistrées pour le moment. Le paiement sera effectué plus tard.</p>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <label for="cardholder" class="form-label">Titulaire de la carte</label>
                                <input type="text" id="cardholder" name="cardholder" class="form-control">
                                <div class="error-message" id="cardholder-error"></div>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="cardNumber" class="form-label">Numéro de carte</label>
                                <input type="text" id="cardNumber" name="cardNumber" class="form-control" placeholder="1234 5678 9012 3456">
                                <div class="error-message" id="cardNumber-error"></div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3">
                                <label for="expiryDate" class="form-label">Date d'expiration</label>
                                <input type="text" id="expiryDate" name="expiryDate" class="form-control" placeholder="MM/AA">
                                <div class="error-message" id="expiryDate-error"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" id="cvv" name="cvv" class="form-control" placeholder="123">
                                <div class="error-message" id="cvv-error"></div>
                            </div>
                        </div>

                        <!-- Conditions -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">conditions générales</a> *
                            </label>
                            <div class="error-message" id="terms-error"></div>
                        </div>

                        <button type="submit" class="btn btn-reserve btn-lg w-100"><i class="fas fa-check-circle me-2"></i>Confirmer la réservation</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Conditions générales -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Conditions générales de location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const form = document.getElementById('reservation-form');

form.addEventListener('submit', function(e){
    e.preventDefault();
    let valid = true;

    // Champs requis côté client (hors paiement)
    const requiredFields = ['lastName','firstName','email','phone',
                            'terms','date_debut','date_fin','lieu_recuperation','lieu_restitution'];

    requiredFields.forEach(id => {
        const field = document.getElementById(id);
        const error = document.getElementById(id+'-error');
        if(field && !field.checkValidity()){
            error && (error.textContent = 'Ce champ est obligatoire');
            valid = false;
        } else { if (error) error.textContent = ''; }
    });

    if(valid){ form.submit(); }
});
</script>

</body>
</html>