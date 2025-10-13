@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">
            <i class="fas fa-calendar-alt"></i> Gestion des Réservations
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
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total</h6>
                            <h3>{{ $stats['total'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Confirmées</h6>
                            <h3>{{ $stats['confirmees'] }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Revenus</h6>
                            <h3>{{ number_format($stats['revenus'], 0) }}€</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-euro-sign fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres par statut -->
    <ul class="nav nav-tabs mb-3" id="reservationTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="toutes-tab" data-bs-toggle="tab" data-bs-target="#toutes" type="button" role="tab">
                Toutes ({{ $stats['total'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="attente-tab" data-bs-toggle="tab" data-bs-target="#attente" type="button" role="tab">
                En attente ({{ $stats['en_attente'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="confirmees-tab" data-bs-toggle="tab" data-bs-target="#confirmees" type="button" role="tab">
                Confirmées ({{ $stats['confirmees'] }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="annulees-tab" data-bs-toggle="tab" data-bs-target="#annulees" type="button" role="tab">
                Annulées ({{ $stats['annulees'] }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="reservationTabsContent">
        <!-- Toutes les réservations -->
        <div class="tab-pane fade show active" id="toutes" role="tabpanel">
            @include('admin.reservations.table', ['reservations_list' => $reservations])
        </div>
        
        <!-- En attente -->
        <div class="tab-pane fade" id="attente" role="tabpanel">
            @include('admin.reservations.table', ['reservations_list' => $reservations->where('statut', 'en_attente')])
        </div>
        
        <!-- Confirmées -->
        <div class="tab-pane fade" id="confirmees" role="tabpanel">
            @include('admin.reservations.table', ['reservations_list' => $reservations->where('statut', 'confirmee')])
        </div>
        
        <!-- Annulées -->
        <div class="tab-pane fade" id="annulees" role="tabpanel">
            @include('admin.reservations.table', ['reservations_list' => $reservations->where('statut', 'annulee')])
        </div>
    </div>
</div>

<!-- Modal de rejet -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Rejeter la réservation</h5>
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
function showRejectModal(reservationId) {
    const form = document.getElementById('rejectForm');
    form.action = `/admin/reservations/${reservationId}/reject`;
    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
    modal.show();
}
</script>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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