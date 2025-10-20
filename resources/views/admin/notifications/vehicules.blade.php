@extends('layouts.app')

@section('title', 'Notifications Véhicules')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-bell"></i> Notifications - Nouveaux Véhicules
                    </h4>
                </div>
                
                <div class="card-body">
                    @if($vehiculesEnAttente->isEmpty())
                        <div class="alert alert-info text-center">
                            <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
                            <h5>Aucune notification</h5>
                            <p class="mb-0">Tous les véhicules ont été traités. Aucun véhicule en attente de validation.</p>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>{{ $vehiculesEnAttente->count() }}</strong> véhicule(s) en attente de validation
                        </div>

                        <div class="row">
                            @foreach($vehiculesEnAttente as $vehicule)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card notification-card border-warning">
                                        <div class="card-header bg-warning text-dark">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small><i class="fas fa-clock"></i> En attente</small>
                                                <small>{{ $vehicule->date_ajout ? $vehicule->date_ajout->diffForHumans() : $vehicule->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        
                                        @if($vehicule->photo)
                                            <img src="{{ asset('storage/' . $vehicule->photo) }}" class="card-img-top" alt="Photo du véhicule" style="height: 200px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                <i class="fas fa-car fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                                            
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted">Année</small><br>
                                                    <strong>{{ $vehicule->annee }}</strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted">Type</small><br>
                                                    <span class="badge badge-secondary">{{ ucfirst($vehicule->type) }}</span>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <small class="text-muted">Immatriculation</small><br>
                                                    <strong>{{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</strong>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <small class="text-muted">Prix par jour</small><br>
                                                    <h5 class="text-primary mb-0">{{ number_format($vehicule->prix_par_jour ?? $vehicule->prix_jour, 0, ',', ' ') }} €</h5>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <small class="text-muted">Propriétaire</small><br>
                                                    <strong>{{ $vehicule->proprietaire->nom ?? 'N/A' }}</strong><br>
                                                    <small class="text-muted">{{ $vehicule->proprietaire->email ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                            
                                            @if($vehicule->description)
                                                <div class="mb-3">
                                                    <small class="text-muted">Description</small><br>
                                                    <p class="small">{{ Str::limit($vehicule->description, 100) }}</p>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-success btn-sm w-100" onclick="validerVehicule({{ $vehicule->id }})">
                                                        <i class="fas fa-check"></i> Valider
                                                    </button>
                                                </div>
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#rejetModal{{ $vehicule->id }}">
                                                        <i class="fas fa-times"></i> Rejeter
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-2">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#detailModal{{ $vehicule->id }}">
                                                        <i class="fas fa-eye"></i> Voir détails
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Détails -->
                                <div class="modal fade" id="detailModal{{ $vehicule->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Détails - {{ $vehicule->marque }} {{ $vehicule->modele }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if($vehicule->photo)
                                                            <img src="{{ asset('storage/' . $vehicule->photo) }}" alt="Photo" class="img-fluid rounded mb-3">
                                                        @endif
                                                        
                                                        <table class="table table-sm">
                                                            <tr><th width="40%">Marque :</th><td>{{ $vehicule->marque }}</td></tr>
                                                            <tr><th>Modèle :</th><td>{{ $vehicule->modele }}</td></tr>
                                                            <tr><th>Année :</th><td>{{ $vehicule->annee }}</td></tr>
                                                            <tr><th>Type :</th><td>{{ $vehicule->type }}</td></tr>
                                                            <tr><th>Couleur :</th><td>{{ $vehicule->couleur }}</td></tr>
                                                            <tr><th>Immatriculation :</th><td>{{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</td></tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <table class="table table-sm">
                                                            <tr><th width="40%">Carburant :</th><td>{{ $vehicule->carburant }}</td></tr>
                                                            <tr><th>Transmission :</th><td>{{ $vehicule->transmission }}</td></tr>
                                                            <tr><th>Places :</th><td>{{ $vehicule->nombre_places ?? $vehicule->nbre_places }}</td></tr>
                                                            <tr><th>Kilométrage :</th><td>{{ number_format($vehicule->kilometrage) }} km</td></tr>
                                                            <tr><th>Localisation :</th><td>{{ $vehicule->localisation }}</td></tr>
                                                            <tr><th>Prix/jour :</th><td><strong>{{ number_format($vehicule->prix_par_jour ?? $vehicule->prix_jour, 0, ',', ' ') }} €</strong></td></tr>
                                                        </table>
                                                        
                                                        @if($vehicule->description)
                                                            <div class="mt-3">
                                                                <strong>Description :</strong>
                                                                <p class="mt-2">{{ $vehicule->description }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <button type="button" class="btn btn-success" onclick="validerVehicule({{ $vehicule->id }})">
                                                    <i class="fas fa-check"></i> Valider
                                                </button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejetModal{{ $vehicule->id }}">
                                                    <i class="fas fa-times"></i> Rejeter
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Rejet -->
                                <div class="modal fade" id="rejetModal{{ $vehicule->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter le véhicule</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.vehicules.reject', $vehicule) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="modal-body">
                                                    <p>Vous êtes sur le point de rejeter le véhicule <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong>.</p>
                                                    <div class="form-group">
                                                        <label for="motif_rejet">Motif du rejet :</label>
                                                        <textarea name="motif_rejet" id="motif_rejet" class="form-control" rows="3" required 
                                                                  placeholder="Expliquez la raison du rejet..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-times"></i> Rejeter
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notification-card {
    transition: transform 0.2s;
}

.notification-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.notification-card .card-header {
    font-size: 0.875rem;
}
</style>

<script>
function validerVehicule(vehiculeId) {
    if (confirm('Êtes-vous sûr de vouloir valider ce véhicule ?')) {
        fetch(`/admin/vehicules/${vehiculeId}/approve`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erreur lors de la validation');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la validation');
        });
    }
}
</script>
@endsection