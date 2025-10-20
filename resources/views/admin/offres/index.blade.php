@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="text-danger fw-bold mb-1">
                <i class="bi bi-award me-2"></i>Offres d'Agence
            </h2>
            <p class="text-muted mb-0">Gestion des offres officielles de l'agence</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour Admin
            </a>
            <a href="{{ route('admin.offres.create') }}" class="btn btn-danger">
                <i class="bi bi-plus-circle me-2"></i>Nouvelle Offre
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 bg-success text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Offres Actives</h5>
                    <h3 class="mb-0">{{ $offres->where('statut', 'active')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-warning text-dark">
                <div class="card-body text-center">
                    <h5 class="card-title">Offres Inactives</h5>
                    <h3 class="mb-0">{{ $offres->where('statut', 'inactive')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-secondary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Offres Expirées</h5>
                    <h3 class="mb-0">{{ $offres->where('statut', 'expired')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 bg-info text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Offres</h5>
                    <h3 class="mb-0">{{ $offres->total() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des offres -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-list-ul me-2"></i>Liste des Offres
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;">
                        <option>Tous les statuts</option>
                        <option value="active">Actives</option>
                        <option value="inactive">Inactives</option>
                        <option value="expired">Expirées</option>
                    </select>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($offres->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Véhicule</th>
                                <th>Prix/Jour</th>
                                <th>Période</th>
                                <th>Réduction</th>
                                <th>Statut</th>
                                <th>Créée le</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($offres as $offre)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-danger rounded-circle p-2 me-3">
                                                <i class="bi bi-car-front-fill text-white"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $offre->vehicule->marque ?? 'N/A' }} {{ $offre->vehicule->modele ?? '' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $offre->vehicule->immatriculation ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($offre->prix_par_jour, 0, ',', ' ') }} FCFA</strong>
                                        @if($offre->vehicule && $offre->prix_par_jour < $offre->vehicule->prix_par_jour)
                                            <br>
                                            <small class="text-muted text-decoration-line-through">
                                                {{ number_format($offre->vehicule->prix_par_jour, 0, ',', ' ') }} FCFA
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            <strong>Du :</strong> {{ \Carbon\Carbon::parse($offre->date_debut_offre)->format('d/m/Y') }}<br>
                                            <strong>Au :</strong> {{ \Carbon\Carbon::parse($offre->date_fin_offre)->format('d/m/Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($offre->date_debut_offre)->diffInDays(\Carbon\Carbon::parse($offre->date_fin_offre)) }} jours
                                        </small>
                                    </td>
                                    <td>
                                        @if($offre->reduction_pourcentage > 0)
                                            <span class="badge bg-warning text-dark">
                                                -{{ $offre->reduction_pourcentage }}%
                                            </span>
                                        @else
                                            <span class="text-muted">Aucune</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $offre->statut === 'active' ? 'success' : ($offre->statut === 'inactive' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($offre->statut) }}
                                        </span>
                                        @if($offre->statut === 'active' && \Carbon\Carbon::parse($offre->date_fin_offre)->isPast())
                                            <br><small class="text-danger">Expirée</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            {{ $offre->created_at->format('d/m/Y') }}
                                            <br>
                                            <span class="text-muted">{{ $offre->created_at->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="{{ route('admin.offres.show', $offre) }}" 
                                               class="btn btn-outline-primary btn-sm" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.offres.edit', $offre) }}" 
                                               class="btn btn-outline-warning btn-sm" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.offres.toggle-status', $offre) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-outline-{{ $offre->statut === 'active' ? 'secondary' : 'success' }} btn-sm"
                                                        title="{{ $offre->statut === 'active' ? 'Désactiver' : 'Activer' }}">
                                                    <i class="bi bi-{{ $offre->statut === 'active' ? 'pause' : 'play' }}"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.offres.destroy', $offre) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette offre ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($offres->hasPages())
                    <div class="card-footer bg-white">
                        {{ $offres->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h4 class="text-muted mt-3">Aucune offre trouvée</h4>
                    <p class="text-muted">Commencez par créer votre première offre d'agence.</p>
                    <a href="{{ route('admin.offres.create') }}" class="btn btn-danger">
                        <i class="bi bi-plus-circle me-2"></i>Créer une offre
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75em;
}
</style>
@endsection