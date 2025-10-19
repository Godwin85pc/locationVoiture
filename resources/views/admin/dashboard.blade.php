@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Admin -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1">
                <i class="bi bi-shield-check me-2"></i>Administration
            </h2>
            <p class="text-muted mb-0">Tableau de bord administrateur - {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Utilisateur
            </a>
            <span class="badge bg-danger fs-6 px-3 py-2">
                <i class="bi bi-person-badge me-1"></i>ADMIN
            </span>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Utilisateurs Total</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_utilisateurs'] ?? 0 }}</h3>
                            <small class="text-white-50">
                                <i class="bi bi-arrow-up"></i> +{{ $stats['nouveaux_utilisateurs_mois'] ?? 0 }} ce mois
                            </small>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-3 p-3">
                            <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Véhicules</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_vehicules'] ?? 0 }}</h3>
                            <small class="text-white-50">
                                <i class="bi bi-check-circle"></i> Catalogue actif
                            </small>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-3 p-3">
                            <i class="bi bi-car-front-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-info text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Réservations</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_reservations'] ?? 0 }}</h3>
                            <small class="text-white-50">
                                <i class="bi bi-activity"></i> {{ $stats['reservations_actives'] ?? 0 }} actives
                            </small>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-3 p-3">
                            <i class="bi bi-calendar-check-fill" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-dark-50 mb-1">Offres Agence</h6>
                            <h3 class="mb-0 fw-bold">{{ $stats['total_offres'] ?? 0 }}</h3>
                            <small class="text-dark-50">
                                <i class="bi bi-star-fill"></i> Catalogue officiel
                            </small>
                        </div>
                        <div class="bg-dark bg-opacity-20 rounded-3 p-3">
                            <i class="bi bi-award-fill text-dark" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-pills card-header-pills" id="adminTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="overview-tab" data-bs-toggle="pill" data-bs-target="#overview" type="button" role="tab">
                                <i class="bi bi-speedometer2 me-2"></i>Vue d'ensemble
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="users-tab" data-bs-toggle="pill" data-bs-target="#users" type="button" role="tab">
                                <i class="bi bi-people me-2"></i>Utilisateurs
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="vehicles-tab" data-bs-toggle="pill" data-bs-target="#vehicles" type="button" role="tab">
                                <i class="bi bi-car-front me-2"></i>Véhicules
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reservations-tab" data-bs-toggle="pill" data-bs-target="#reservations" type="button" role="tab">
                                <i class="bi bi-calendar-check me-2"></i>Réservations
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="validation-tab" data-bs-toggle="pill" data-bs-target="#validation" type="button" role="tab">
                                <i class="bi bi-check-circle me-2"></i>Validation
                                @if(isset($vehicules_en_attente) && $vehicules_en_attente->count() > 0)
                                    <span class="badge bg-danger">{{ $vehicules_en_attente->count() }}</span>
                                @endif
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="adminTabsContent">
                        
                        <!-- Vue d'ensemble -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel">
                            <div class="row g-4">
                                <!-- Graphique utilisateurs par rôle -->
                                <div class="col-lg-6">
                                    <h5 class="mb-3">
                                        <i class="bi bi-pie-chart text-primary me-2"></i>Répartition des utilisateurs
                                    </h5>
                                    <div class="bg-light rounded p-4">
                                        @if(isset($utilisateurs_par_role))
                                            @foreach($utilisateurs_par_role as $role => $count)
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span class="fw-semibold text-capitalize">
                                                        <i class="bi bi-person-badge me-2 text-{{ $role === 'admin' ? 'danger' : ($role === 'client' ? 'primary' : 'success') }}"></i>
                                                        {{ ucfirst($role) }}
                                                    </span>
                                                    <span class="badge bg-{{ $role === 'admin' ? 'danger' : ($role === 'client' ? 'primary' : 'success') }}">
                                                        {{ $count }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                <!-- Derniers utilisateurs -->
                                <div class="col-lg-6">
                                    <h5 class="mb-3">
                                        <i class="bi bi-person-plus text-success me-2"></i>Nouveaux utilisateurs
                                    </h5>
                                    <div class="list-group list-group-flush">
                                        @forelse($derniers_utilisateurs ?? [] as $user)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $user->prenom }} {{ $user->nom }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $user->email }}</small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'client' ? 'primary' : 'success') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center text-muted py-4">
                                                <i class="bi bi-inbox"></i> Aucun utilisateur récent
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gestion des utilisateurs -->
                        <div class="tab-pane fade" id="users" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">
                                    <i class="bi bi-people text-primary me-2"></i>Gestion des utilisateurs
                                </h5>
                                <button class="btn btn-primary">
                                    <i class="bi bi-person-plus me-2"></i>Ajouter un utilisateur
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Utilisateur</th>
                                            <th>Email</th>
                                            <th>Rôle</th>
                                            <th>Inscription</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($derniers_utilisateurs ?? [] as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle p-2 me-3">
                                                            <i class="bi bi-person-fill text-white"></i>
                                                        </div>
                                                        <div>
                                                            <strong>{{ $user->prenom }} {{ $user->nom }}</strong>
                                                            @if($user->telephone)
                                                                <br><small class="text-muted">{{ $user->telephone }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'client' ? 'primary' : 'success') }}">
                                                        {{ ucfirst($user->role) }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    @if($user->email_verified_at)
                                                        <span class="badge bg-success">Vérifié</span>
                                                    @else
                                                        <span class="badge bg-warning">En attente</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" title="Voir">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                        <button class="btn btn-outline-warning" title="Modifier">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        @if($user->role !== 'admin')
                                                            <button class="btn btn-outline-danger" title="Supprimer">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox"></i> Aucun utilisateur trouvé
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Gestion des véhicules -->
                        <div class="tab-pane fade" id="vehicles" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">
                                    <i class="bi bi-car-front text-success me-2"></i>Catalogue des véhicules
                                </h5>
                                <div>
                                    <a href="{{ route('admin.offres.index') }}" class="btn btn-warning me-2">
                                        <i class="bi bi-award me-2"></i>Gérer les offres
                                    </a>
                                    <button class="btn btn-success me-2">
                                        <i class="bi bi-plus-circle me-2"></i>Ajouter un véhicule agence
                                    </button>
                                    <button class="btn btn-outline-info">
                                        <i class="bi bi-funnel me-2"></i>Filtrer
                                    </button>
                                </div>
                            </div>

                            <!-- Statistiques véhicules -->
                            @if(isset($vehicules_par_statut))
                                <div class="row g-3 mb-4">
                                    @foreach($vehicules_par_statut as $statut => $count)
                                        <div class="col-md-3">
                                            <div class="card border-0 bg-light">
                                                <div class="card-body text-center">
                                                    <h6 class="text-capitalize mb-1">{{ str_replace('_', ' ', $statut) }}</h6>
                                                    <h4 class="mb-0 text-{{ $statut === 'disponible' ? 'success' : ($statut === 'reserve' ? 'warning' : 'info') }}">
                                                        {{ $count }}
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Cette section sera complétée avec la liste détaillée des véhicules et leurs fonctionnalités de gestion.
                            </div>
                        </div>

                        <!-- Gestion des réservations -->
                        <div class="tab-pane fade" id="reservations" role="tabpanel">
                            <h5 class="mb-4">
                                <i class="bi bi-calendar-check text-info me-2"></i>Suivi des réservations
                            </h5>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Module en développement</strong><br>
                                Cette section sera complétée par votre camarade qui travaille sur le module de réservation.
                            </div>
                        </div>

                        <!-- Validation des véhicules -->
                        <div class="tab-pane fade" id="validation" role="tabpanel">
                            <h5 class="mb-4">
                                <i class="bi bi-check-circle text-warning me-2"></i>Validation des propositions
                            </h5>

                            @if(isset($vehicules_en_attente) && $vehicules_en_attente->count() > 0)
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ $vehicules_en_attente->count() }} véhicule(s) en attente de validation
                                </div>

                                <div class="row g-4">
                                    @foreach($vehicules_en_attente as $vehicule)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="card border-warning">
                                                <div class="card-header bg-warning text-dark">
                                                    <strong>En attente de validation</strong>
                                                </div>
                                                <div class="card-body">
                                                    <h6>{{ $vehicule->marque }} {{ $vehicule->modele }}</h6>
                                                    <p class="text-muted">{{ $vehicule->description }}</p>
                                                    <div class="d-flex gap-2">
                 <!-- Bouton pour valider et envoyer le mail -->
                                          <form action="{{ route('admin. validerVehicule', $vehicule->id) }}" method="POST">
                                   @csrf
                               <button type="submit" class="btn btn-success btn-sm">
                                        <i class="bi bi-check-circle"></i> Valider et envoyer le mail
                                       </button>
                                         </form>

                                <!-- Bouton pour rejeter -->
                          <button class="btn btn-danger btn-sm">
                        <i class="bi bi-x-circle"></i> Rejeter
                                </button>
                                         </div>

                                                </div>
                                            </div>
                                        </div>
                                                
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-success">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Aucun véhicule en attente de validation
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.nav-pills .nav-link {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.1);
}

.badge {
    font-size: 0.75em;
}

.bg-opacity-20 {
    --bs-bg-opacity: 0.2;
}

.text-white-50 {
    color: rgba(255, 255, 255, 0.7) !important;
}

.text-dark-50 {
    color: rgba(0, 0, 0, 0.7) !important;
}
</style>
@endsection