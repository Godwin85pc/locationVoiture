
<!-- filepath: c:\Users\HP USERS\Desktop\3IL\I2FE\SEMESTRE1\INFORMATIQUE\WEB\PROJETS\locationVoiture\resources\views\index.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Location de véhicules - Accueil</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
        }
        .hero {
            padding: 80px 0 40px 0;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1.2s forwards;
        }
        .fade-in.delay-1 { animation-delay: 0.3s; }
        .fade-in.delay-2 { animation-delay: 0.6s; }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .btn-custom {
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            border: none;
            box-shadow: 0 4px 20px rgba(0,123,255,0.15);
            transition: transform 0.2s;
        }
        .btn-custom:hover {
            transform: scale(1.07);
            background: linear-gradient(90deg, #00c6ff 0%, #007bff 100%);
        }
        .card-vehicule {
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .card-vehicule:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            transform: translateY(-8px) scale(1.03);
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm px-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="#">LocationVoiture</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Véhicules</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Réservations</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="conecter.html">Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Section Hero / Accueil -->
    <section class="hero container">
        <div class="row align-items-center">
            <div class="col-md-6 fade-in delay-1">
                <h1 class="display-4 fw-bold mb-3">Louez votre véhicule en toute simplicité</h1>
                <p class="lead mb-4">Découvrez notre sélection de voitures modernes et profitez d'une expérience de location rapide, sécurisée et personnalisée.</p>
                <a href="#formulaire-location" class="btn btn-custom btn-lg shadow">Réserver un véhicule</a>
            </div>
        </div>
    </section>

    <!-- Section véhicules populaires -->
    <section class="container mt-5">
        <h2 class="text-center mb-4 fade-in delay-1">Nos véhicules populaires</h2>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4 fade-in delay-2">
                <div class="card card-vehicule shadow-sm">
                    <img src="" class="card-img-top" alt="SUV">
                    <div class="card-body">
                        <h5 class="card-title">SUV Confort</h5>
                        <p class="card-text">Idéal pour les familles et les longs trajets. Espace et sécurité garantis.</p>
                        <a href="#" class="btn btn-outline-primary">Réserver</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 fade-in delay-2">
                <div class="card card-vehicule shadow-sm">
                    <img src="" class="card-img-top" alt="Berline">
                    <div class="card-body">
                        <h5 class="card-title">Berline Élégante</h5>
                        <p class="card-text">Pour vos déplacements professionnels ou privés avec style et confort.</p>
                        <a href="#" class="btn btn-outline-primary">Réserver</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4 fade-in delay-2">
                <div class="card card-vehicule shadow-sm">
                    <img src="" class="card-img-top" alt="Citadine">
                    <div class="card-body">
                        <h5 class="card-title">Citadine Pratique</h5>
                        <p class="card-text">Parfaite pour la ville, facile à garer et économique en carburant.</p>
                        <a href="#" class="btn btn-outline-primary">Réserver</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formulaire de recherche/location -->
<!-- filepath: c:\Users\HP USERS\Desktop\3IL\I2FE\SEMESTRE1\INFORMATIQUE\WEB\PROJETS\locationVoiture\resources\views\index.blade.php -->
<!-- ...existing code... -->
<section id="formulaire-location" class="container d-flex justify-content-center mt-5">
    <div class="p-4 rounded bg-light w-100 shadow-lg border" style="max-width: 600px; background: rgba(255,255,255,0.95);">
        <h4 class="mb-4 text-center text-primary fw-bold">
            <i class="bi bi-calendar-check"></i> Réservez votre véhicule
        </h4>
        <!-- Lieu de récupération -->
        <div class="mb-4">
            <label class="form-label fw-semibold" for="lieuRecup">
                <i class="bi bi-geo-alt-fill text-primary"></i> Lieu de récupération du véhicule :
            </label>
            <input type="text" class="form-control form-control-lg" id="lieuRecup" placeholder="Entrez le lieu de récupération" />
        </div>
        <!-- Heure de sollicitation -->
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="bi bi-clock-history text-primary"></i> Sollicitation du véhicule :
            </label>
            <div class="row g-2">
                <div class="col">
                    <input type="date" class="form-control" id="dateDepart" />
                </div>
                <div class="col">
                    <input type="time" class="form-control" id="heureDepart" />
                </div>
            </div>
        </div>
        <!-- Lieu de retour -->
        <div class="mb-4">
            <label class="form-label fw-semibold" for="lieuRetour">
                <i class="bi bi-geo-alt text-primary"></i> Lieu de retour du véhicule :
            </label>
            <input type="text" class="form-control form-control-lg" id="lieuRetour" placeholder="Entrez le lieu de retour" />
        </div>
        <!-- Retour du véhicule -->
        <div class="mb-4">
            <label class="form-label fw-semibold">
                <i class="bi bi-arrow-repeat text-primary"></i> Retour du véhicule :
            </label>
            <div class="row g-2">
                <div class="col">
                    <input type="date" class="form-control" id="dateRetour" />
                </div>
                <div class="col">
                    <input type="time" class="form-control" id="heureRetour" />
                </div>
            </div>
        </div>
        <!-- Checkbox -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="ageCheck" />
            <label class="form-check-label fw-semibold" for="ageCheck">
                <i class="bi bi-person-badge text-primary"></i> Conducteur entre 25 et 30 ans
            </label>
        </div>
        <!-- Lien client fidèle -->
        <p class="mb-3 text-center">
            <a href="#" class="text-decoration-underline text-success fw-semibold">Êtes-vous client fidèle ?</a>
        </p>
        <!-- Bouton Rechercher -->
       <a href="{{ url('voiture2') }}" 
   class="btn btn-primary btn-lg px-5 shadow">
    <i class="bi bi-search"></i> Rechercher
</a>
</section>
<!-- ...existing code... -->
<!-- Ajoute l'icône Bootstrap Icons CDN dans le <head> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation JS pour déclencher fade-in au scroll
        document.addEventListener('DOMContentLoaded', function() {
            function reveal() {
                document.querySelectorAll('.fade-in').forEach(function(el) {
                    var rect = el.getBoundingClientRect();
                    if (rect.top < window.innerHeight - 50) {
                        el.style.animationPlayState = 'running';
                    }
                });
            }
            window.addEventListener('scroll', reveal);
            reveal();
        });
    </script>
</body>
</html>