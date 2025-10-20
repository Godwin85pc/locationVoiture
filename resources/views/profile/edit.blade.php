@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-primary fw-bold mb-1">
                <i class="bi bi-person-gear me-2"></i>Mon Profil
            </h2>
            <p class="text-muted mb-0">Gérez vos informations personnelles et vos préférences</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Retour au tableau de bord
        </a>
    </div>

    <div class="row g-4">
        <!-- Informations du profil -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-lines-fill me-2"></i>Informations personnelles
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            Profil mis à jour avec succès !
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="nom" class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary me-2"></i>Nom
                                </label>
                                <input id="nom" 
                                       type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       name="nom" 
                                       value="{{ old('nom', Auth::user()->nom) }}" 
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="prenom" class="form-label fw-semibold">
                                    <i class="bi bi-person text-primary me-2"></i>Prénom
                                </label>
                                <input id="prenom" 
                                       type="text" 
                                       class="form-control @error('prenom') is-invalid @enderror" 
                                       name="prenom" 
                                       value="{{ old('prenom', Auth::user()->prenom) }}" 
                                       required>
                                @error('prenom')
                                    <div class="invalid-feedback">
                                        <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope text-primary me-2"></i>Adresse email
                            </label>
                            <input id="email" 
                                   type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            
                            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                                <div class="alert alert-warning mt-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Votre adresse email n'est pas vérifiée.
                                    <form method="POST" action="{{ route('verification.send') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 align-baseline">
                                            Cliquez ici pour renvoyer l'email de vérification
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="telephone" class="form-label fw-semibold">
                                <i class="bi bi-phone text-primary me-2"></i>Téléphone
                                <small class="text-muted">(optionnel)</small>
                            </label>
                            <input id="telephone" 
                                   type="tel" 
                                   class="form-control @error('telephone') is-invalid @enderror" 
                                   name="telephone" 
                                   value="{{ old('telephone', Auth::user()->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar avec informations supplémentaires -->
        <div class="col-lg-4">
            <!-- Carte de résumé du profil -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Informations du compte
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary rounded-circle p-3 me-3">
                            <i class="bi bi-person-fill text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h6>
                            <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Membre depuis :</span>
                            <span>{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Email vérifié :</span>
                            <span>
                                @if(Auth::user()->email_verified_at)
                                    <i class="bi bi-check-circle-fill text-success"></i> Oui
                                @else
                                    <i class="bi bi-x-circle-fill text-danger"></i> Non
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Changement de mot de passe -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-shield-lock me-2"></i>Sécurité
                    </h6>
                </div>
                <div class="card-body">
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            Mot de passe mis à jour !
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="bi bi-lock text-warning me-2"></i>Mot de passe actuel
                            </label>
                            <input id="current_password" 
                                   type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   name="current_password" 
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="bi bi-lock-fill text-warning me-2"></i>Nouveau mot de passe
                            </label>
                            <input id="password" 
                                   type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">
                                <i class="bi bi-check2-circle text-warning me-2"></i>Confirmer le nouveau mot de passe
                            </label>
                            <input id="password_confirmation" 
                                   type="password" 
                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   name="password_confirmation" 
                                   required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-triangle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-shield-check me-2"></i>Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">
                        <i class="bi bi-lightning me-2"></i>Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('vehicules.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-car-front me-2"></i>Mes véhicules
                        </a>
                        <a href="{{ route('reservations.index') }}" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-calendar-check me-2"></i>Mes réservations
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.btn-custom {
    background: linear-gradient(90deg, #007bff 0%, #00c6ff 100%);
    color: #fff;
    border: none;
    box-shadow: 0 4px 20px rgba(0,123,255,0.15);
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 12px;
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0,123,255,0.25);
    background: linear-gradient(90deg, #00c6ff 0%, #007bff 100%);
    color: #fff;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.1);
}

.card {
    border-radius: 15px;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}
</style>
@endsection
