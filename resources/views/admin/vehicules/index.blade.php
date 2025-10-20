@extends('layouts.app')

@section('title', 'Gestion des Véhicules')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-car"></i> Gestion des Véhicules
                    </h4>
                    <div>
                        <span class="badge badge-warning">{{ $vehiculesEnAttente->count() }} en attente</span>
                        <span class="badge badge-success">{{ $vehiculesValides->count() }} validés</span>
                        <span class="badge badge-danger">{{ $vehiculesRejetes->count() }} rejetés</span>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Filtres -->
                    <ul class="nav nav-tabs mb-4" id="vehiculesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="en-attente-tab" data-bs-toggle="tab" data-bs-target="#en-attente" type="button" role="tab">
                                <i class="fas fa-clock text-warning"></i> En attente ({{ $vehiculesEnAttente->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="valides-tab" data-bs-toggle="tab" data-bs-target="#valides" type="button" role="tab">
                                <i class="fas fa-check-circle text-success"></i> Validés ({{ $vehiculesValides->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="rejetes-tab" data-bs-toggle="tab" data-bs-target="#rejetes" type="button" role="tab">
                                <i class="fas fa-times-circle text-danger"></i> Rejetés ({{ $vehiculesRejetes->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="vehiculesTabsContent">
                        <!-- Véhicules en attente -->
                        <div class="tab-pane fade show active" id="en-attente" role="tabpanel">
                            @if($vehiculesEnAttente->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucun véhicule en attente de validation.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Véhicule</th>
                                                <th>Propriétaire</th>
                                                <th>Type</th>
                                                <th>Prix/jour</th>
                                                <th>Date d'ajout</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vehiculesEnAttente as $vehicule)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($vehicule->photo)
                                                            <img src="{{ asset('storage/' . $vehicule->photo) }}" alt="Photo" class="rounded me-2" width="50" height="40" style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                                                <i class="fas fa-car text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong><br>
                                                            <small class="text-muted">{{ $vehicule->annee }} - {{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $vehicule->proprietaire->nom ?? 'N/A' }}<br>
                                                    <small class="text-muted">{{ $vehicule->proprietaire->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ ucfirst($vehicule->type) }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ number_format($vehicule->prix_par_jour ?? $vehicule->prix_jour, 0, ',', ' ') }} €</strong>
                                                </td>
                                                <td>
                                                    {{ $vehicule->date_ajout ? $vehicule->date_ajout->format('d/m/Y H:i') : $vehicule->created_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $vehicule->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-success" onclick="validerVehicule({{ $vehicule->id }})">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejetModal{{ $vehicule->id }}">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>

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
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <!-- Véhicules validés -->
                        <div class="tab-pane fade" id="valides" role="tabpanel">
                            @if($vehiculesValides->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucun véhicule validé.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Véhicule</th>
                                                <th>Propriétaire</th>
                                                <th>Type</th>
                                                <th>Prix/jour</th>
                                                <th>Date validation</th>
                                                <th>Réservations</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vehiculesValides as $vehicule)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($vehicule->photo)
                                                            <img src="{{ asset('storage/' . $vehicule->photo) }}" alt="Photo" class="rounded me-2" width="50" height="40" style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                                                <i class="fas fa-car text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong><br>
                                                            <small class="text-muted">{{ $vehicule->annee }} - {{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $vehicule->proprietaire->nom ?? 'N/A' }}<br>
                                                    <small class="text-muted">{{ $vehicule->proprietaire->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ ucfirst($vehicule->type) }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ number_format($vehicule->prix_par_jour ?? $vehicule->prix_jour, 0, ',', ' ') }} €</strong>
                                                </td>
                                                <td>
                                                    {{ $vehicule->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $vehicule->reservations->count() }}</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $vehicule->id }}">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <!-- Véhicules rejetés -->
                        <div class="tab-pane fade" id="rejetes" role="tabpanel">
                            @if($vehiculesRejetes->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Aucun véhicule rejeté.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Véhicule</th>
                                                <th>Propriétaire</th>
                                                <th>Type</th>
                                                <th>Motif du rejet</th>
                                                <th>Date rejet</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($vehiculesRejetes as $vehicule)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($vehicule->photo)
                                                            <img src="{{ asset('storage/' . $vehicule->photo) }}" alt="Photo" class="rounded me-2" width="50" height="40" style="object-fit: cover;">
                                                        @else
                                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 50px; height: 40px;">
                                                                <i class="fas fa-car text-white"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong><br>
                                                            <small class="text-muted">{{ $vehicule->annee }} - {{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $vehicule->proprietaire->nom ?? 'N/A' }}<br>
                                                    <small class="text-muted">{{ $vehicule->proprietaire->email ?? 'N/A' }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">{{ ucfirst($vehicule->type) }}</span>
                                                </td>
                                                <td>
                                                    <small class="text-danger">{{ $vehicule->motif_rejet ?? 'Aucun motif spécifié' }}</small>
                                                </td>
                                                <td>
                                                    {{ $vehicule->updated_at->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $vehicule->id }}">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-warning" onclick="remettreEnAttente({{ $vehicule->id }})">
                                                            <i class="fas fa-undo"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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

function remettreEnAttente(vehiculeId) {
    if (confirm('Êtes-vous sûr de vouloir remettre ce véhicule en attente ?')) {
        fetch(`/admin/vehicules/${vehiculeId}/resume`, {
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
                alert('Erreur lors de la remise en attente');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la remise en attente');
        });
    }
}
</script>
@endsection