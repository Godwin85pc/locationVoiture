@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Admin -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1">
                <i class="bi bi-shield-check me-2"></i>Administration
            </h2>
            <p class="text-muted mb-0">Tableau de bord administrateur - {{ optional(Auth::guard('admin')->user())->prenom }} {{ optional(Auth::guard('admin')->user())->nom }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.preview.user-dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard Utilisateur
            </a>
            <span class="badge bg-danger fs-6 px-3 py-2">
                <i class="bi bi-person-badge me-1"></i>ADMIN
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
                                            <!-- Derniers utilisateurs -->
                                            <div class="col-12">
                                                <h5 class="mb-3">
                                                    <i class="bi bi-person-plus text-success me-2"></i>Nouveaux utilisateurs
                                                </h5>
                                                <div class="list-group list-group-flush">
                                                    @forelse($derniers_utilisateurs ?? [] as $u)
                                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <strong>{{ optional($u)->prenom }} {{ optional($u)->nom }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ optional($u)->email }}</small>
                                                            </div>
                                                            <div class="text-end">
                                                                <span class="badge bg-{{ (optional($u)->role) === 'admin' ? 'danger' : ((optional($u)->role) === 'client' ? 'primary' : 'success') }}">
                                                                    {{ ucfirst(optional($u)->role) }}
                                                                </span>
                                                                <br>
                                                                <small class="text-muted">{{ optional(optional($u)->created_at)->diffForHumans() }}</small>
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
                                                <span class="badge bg-secondary ms-2">Total: {{ $stats['total_utilisateurs'] ?? 0 }}</span>
                                            </h5>
                                            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-box-arrow-up-right me-2"></i>Ouvrir en plein écran
                                            </a>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Utilisateur</th>
                                                        <th>Email</th>
                                                        <th>Rôle</th>
                                                        <th>Inscription</th>
                                                        <th class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse(($utilisateurs ?? collect()) as $u)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-primary rounded-circle p-2 me-3">
                                                                        <i class="bi bi-person-fill text-white"></i>
                                                                    </div>
                                                                    <div>
                                                                        <strong>{{ optional($u)->prenom }} {{ optional($u)->nom }}</strong>
                                                                        @if(optional($u)->telephone)
                                                                            <br><small class="text-muted">{{ optional($u)->telephone }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ optional($u)->email }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ (optional($u)->role) === 'admin' ? 'danger' : ((optional($u)->role) === 'client' ? 'primary' : 'success') }}">
                                                                    {{ ucfirst(optional($u)->role) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ optional(optional($u)->created_at)->format('d/m/Y') }}</td>
                                                            <td class="text-end">
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{ route('admin.utilisateurs.show', $u) }}" class="btn btn-outline-primary" title="Voir">
                                                                        <i class="bi bi-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.utilisateurs.edit', $u) }}" class="btn btn-outline-warning" title="Modifier">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </a>
                                                                    @if(optional($u)->role !== 'admin')
                                                                        <form action="{{ route('admin.utilisateurs.destroy', $u) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button class="btn btn-outline-danger" title="Supprimer">
                                                                                <i class="bi bi-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="5" class="text-center text-muted py-4">
                                                                <i class="bi bi-inbox"></i> Aucun utilisateur trouvé
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        @if(isset($utilisateurs) && method_exists($utilisateurs, 'links'))
                                            <div>
                                                {{ $utilisateurs->links() }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Gestion des véhicules -->
                                    <div class="tab-pane fade" id="vehicles" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">
                                                <i class="bi bi-car-front text-success me-2"></i>Catalogue des véhicules
                                            </h5>
                                        </div>

                                        <!-- Statistiques véhicules -->
                                        @if(isset($vehicules_par_statut))
                                            <div class="row g-3 mb-4">
                                                @foreach($vehicules_par_statut as $statut => $count)
                                                    <div class="col-md-3">
                                                        <div class="card border-0 bg-light">
                                                            <div class="card-body text-center">
                                                                <h6 class="text-capitalize mb-1">{{ str_replace('_', ' ', $statut) }}</h6>
                                                                <h4 class="mb-0 text-{{ $statut === 'disponible' ? 'success' : ($statut === 'en_attente' ? 'warning' : ($statut === 'rejete' ? 'danger' : 'info')) }}">
                                                                    {{ $count }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Liste complète des véhicules -->
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Véhicule</th>
                                                        <th>Propriétaire</th>
                                                        <th>Localisation</th>
                                                        <th>Statut</th>
                                                        <th>Ajout</th>
                                                        <th class="text-end">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse(($tous_vehicules ?? collect()) as $vehicule)
                                                        <tr>
                                                            <td>{{ $vehicule->id }}</td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="bg-light rounded me-3" style="width:48px;height:36px;overflow:hidden;">
                                                                        <img src="{{ $vehicule->photo_url ?? 'https://via.placeholder.com/80x60' }}" alt="photo" style="width:100%;height:100%;object-fit:cover;">
                                                                    </div>
                                                                    <div>
                                                                        <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong><br>
                                                                        <small class="text-muted">{{ $vehicule->immatriculation }}</small>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <small>{{ optional($vehicule->proprietaire)->prenom }} {{ optional($vehicule->proprietaire)->nom }}</small><br>
                                                                <small class="text-muted">{{ optional($vehicule->proprietaire)->email }}</small>
                                                            </td>
                                                            <td>{{ $vehicule->localisation }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $vehicule->statut === 'disponible' ? 'success' : ($vehicule->statut === 'en_attente' ? 'warning' : 'secondary') }}">
                                                                    {{ str_replace('_',' ', ucfirst($vehicule->statut)) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ optional($vehicule->created_at)->format('d/m/Y') }}</td>
                                                            <td class="text-end">
                                                                <div class="btn-group btn-group-sm">
                                                                    <form action="{{ route('admin.vehicules.approve', $vehicule) }}" method="POST" onsubmit="return confirm('Approuver ce véhicule ?')">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button class="btn btn-outline-success" title="Approuver"><i class="bi bi-check"></i></button>
                                                                    </form>
                                                                    <form action="{{ route('admin.vehicules.reject', $vehicule) }}" method="POST" onsubmit="return confirm('Rejeter ce véhicule ?')">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button class="btn btn-outline-danger" title="Rejeter"><i class="bi bi-x"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="text-center text-muted py-4">Aucun véhicule à afficher pour le moment.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Gestion des réservations -->
                                    <div class="tab-pane fade" id="reservations" role="tabpanel">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h5 class="mb-0">
                                                <i class="bi bi-calendar-check text-info me-2"></i>Suivi des réservations
                                            </h5>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-striped align-middle">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Client</th>
                                                        <th>Véhicule</th>
                                                        <th>Période</th>
                                                        <th>Lieu</th>
                                                        <th>Statut</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse(($dernieres_reservations ?? []) as $r)
                                                        <tr>
                                                            <td>{{ $r->id ?? '' }}</td>
                                                            <td>
                                                                <div><strong>{{ $r?->utilisateur?->prenom }} {{ $r?->utilisateur?->nom }}</strong></div>
                                                                <small class="text-muted">{{ $r?->utilisateur?->email }}</small>
                                                            </td>
                                                            <td>
                                                                <div><strong>{{ $r?->vehicule?->marque }} {{ $r?->vehicule?->modele }}</strong></div>
                                                                <small class="text-muted">{{ $r?->vehicule?->immatriculation }}</small>
                                                            </td>
                                                            <td>
                                                                {{ ($r && $r->date_debut) ? \Carbon\Carbon::parse($r->date_debut)->format('d/m/Y H:i') : '' }} → {{ ($r && $r->date_fin) ? \Carbon\Carbon::parse($r->date_fin)->format('d/m/Y H:i') : '' }}
                                                            </td>
                                                            <td>{{ $r->lieu_recuperation ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ ($r->statut ?? '') === 'confirmee' ? 'success' : (($r->statut ?? '') === 'en_attente' ? 'warning' : 'secondary') }}">
                                                                    {{ ucfirst($r->statut ?? 'inconnu') }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted py-4">
                                                                <i class="bi bi-inbox"></i> Aucune réservation récente.
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
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
                                                                    <form action="{{ route('admin.vehicules.approve', $vehicule) }}" method="POST" onsubmit="return confirm('Approuver ce véhicule ?')">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button class="btn btn-success btn-sm">
                                                                            <i class="bi bi-check"></i> Approuver
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('admin.vehicules.reject', $vehicule) }}" method="POST" onsubmit="return confirm('Rejeter ce véhicule ?')">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <button class="btn btn-danger btn-sm">
                                                                            <i class="bi bi-x"></i> Rejeter
                                                                        </button>
                                                                    </form>
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
    <script>
        // Auto-hide flash alerts after 4 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(a => {
                if (a.classList.contains('show')) {
                    a.classList.remove('show');
                }
            });
        }, 4000);
    </script>
</div>
@endsection