@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">
            <i class="fas fa-car"></i> Gestion des Véhicules
        </h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour au dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-2-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total</h6>
                            <h3>{{ $stats['total'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-car fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">En attente</h6>
                            <h3>{{ $stats['en_attente'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Disponibles</h6>
                            <h3>{{ $stats['disponibles'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Loués</h6>
                            <h3>{{ $stats['loues'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-key fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Rejetés</h6>
                            <h3>{{ $stats['rejetes'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-times fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres par statut -->
    <ul class="nav nav-tabs mb-3" id="vehiculeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tous-tab" data-bs-toggle="tab" data-bs-target="#tous" type="button" role="tab">
                Tous ({{ $stats['total'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="attente-tab" data-bs-toggle="tab" data-bs-target="#attente" type="button" role="tab">
                En attente ({{ $stats['en_attente'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="disponibles-tab" data-bs-toggle="tab" data-bs-target="#disponibles" type="button" role="tab">
                Disponibles ({{ $stats['disponibles'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="loues-tab" data-bs-toggle="tab" data-bs-target="#loues" type="button" role="tab">
                Loués ({{ $stats['loues'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="rejetes-tab" data-bs-toggle="tab" data-bs-target="#rejetes" type="button" role="tab">
                Rejetés ({{ $stats['rejetes'] }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="vehiculeTabsContent">
        <!-- Tous les véhicules -->
        <div class="tab-pane fade show active" id="tous" role="tabpanel">
            @include('admin.vehicules.table', ['vehicules_list' => $vehicules])
        </div>
        
        <!-- En attente -->
        <div class="tab-pane fade" id="attente" role="tabpanel">
            @include('admin.vehicules.table', ['vehicules_list' => $vehicules->where('statut', 'en_attente')])
        </div>
        
        <!-- Disponibles -->
        <div class="tab-pane fade" id="disponibles" role="tabpanel">
            @include('admin.vehicules.table', ['vehicules_list' => $vehicules->where('statut', 'disponible')])
        </div>
        
        <!-- Loués -->
        <div class="tab-pane fade" id="loues" role="tabpanel">
            @include('admin.vehicules.table', ['vehicules_list' => $vehicules->where('statut', 'loue')])
        </div>
        
        <!-- Rejetés -->
        <div class="tab-pane fade" id="rejetes" role="tabpanel">
            @include('admin.vehicules.table', ['vehicules_list' => $vehicules->where('statut', 'rejete')])
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Rejeter le véhicule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motif_rejet" class="form-label">Motif du rejet (optionnel)</label>
                        <textarea class="form-control" id="motif_rejet" name="motif_rejet" rows="3" placeholder="Expliquez la raison du rejet..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(vehiculeId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/vehicules/${vehiculeId}/reject`;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.col-md-2-4 {
    flex: 0 0 20%;
    max-width: 20%;
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
}

.btn-action {
    margin: 0 2px;
}
</style>
@endsection