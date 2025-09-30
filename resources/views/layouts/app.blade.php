<!-- filepath: c:\Users\HP USERS\Desktop\3IL\I2FE\SEMESTRE1\INFORMATIQUE\WEB\PROJETS\locationVoiture\resources\views\layouts\app.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'LocationVoiture')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">LocationVoiture</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('vehicules.index') }}">Véhicules</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('reservations.index') }}">Réservations</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('connexion') }}">Se connecter</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="container">
        @yield('content')
    </main>
    <footer class="bg-dark text-white py-3 mt-5">
        <div class="container text-center">
            &copy; {{ date('Y') }} LocationVoiture. Tous droits réservés.
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>