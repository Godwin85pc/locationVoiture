<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Connexion</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-custom {
            background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
            color: #fff;
            border: none;
            box-shadow: 0 4px 20px rgba(0,123,255,0.15);
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,123,255,0.25);
            background: linear-gradient(90deg, #00c6ff 0%, #007bff 100%);
            color: #fff;
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.1);
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
        }
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s forwards;
        }
        .fade-in.delay-1 { animation-delay: 0.3s; }
        .fade-in.delay-2 { animation-delay: 0.6s; }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .link-register {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .link-register:hover {
            color: #00c6ff;
            text-decoration: underline;
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm px-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ url('/') }}">
                <i class="bi bi-car-front-fill me-2"></i>LocationVoiture
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link active" href="{{ route('login') }}">Se connecter</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S'inscrire</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Formulaire de connexion -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-container p-5 fade-in">
                    <div class="text-center mb-4 fade-in delay-1">
                        <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                        <h2 class="fw-bold text-primary mt-3 mb-2">Bienvenue !</h2>
                        <p class="text-muted">Connectez-vous à votre compte</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4 fade-in delay-2">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="fade-in delay-2">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope text-primary me-2"></i>Adresse email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="votre.email@exemple.com">
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mot de passe -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock text-primary me-2"></i>Mot de passe
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="Entrez votre mot de passe">
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                <label class="form-check-label text-muted" for="remember_me">
                                    Se souvenir de moi
                                </label>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-custom btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>
                            
                            <div class="text-center">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="link-register me-3">
                                        <i class="bi bi-key me-1"></i>Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>
                            
                            <div class="text-center pt-3 border-top">
                                <p class="text-muted mb-2">Pas encore inscrit ?</p>
                                <a href="{{ route('register') }}" class="link-register">
                                    <i class="bi bi-person-plus me-1"></i>Créer un compte gratuitement
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
