<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Véhicule</th>
                <th>Propriétaire</th>
                <th>Type</th>
                <th>Prix/jour</th>
                <th>Statut</th>
                <th>Date ajout</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vehicules_list as $vehicule)
            <tr>
                <td>{{ $vehicule->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        @if($vehicule->photo)
                            <img src="{{ $vehicule->photo }}" alt="Photo" class="me-2" style="width: 50px; height: 35px; object-fit: cover; border-radius: 5px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 50px; height: 35px;">
                                <i class="fas fa-car text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong>
                            <br><small class="text-muted">{{ $vehicule->immatriculation }}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                            {{ strtoupper(substr($vehicule->proprietaire->prenom ?? 'N', 0, 1)) }}{{ strtoupper(substr($vehicule->proprietaire->nom ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $vehicule->proprietaire->nom ?? 'N/A' }} {{ $vehicule->proprietaire->prenom ?? '' }}</strong>
                            <br><small class="text-muted">{{ $vehicule->proprietaire->email ?? 'N/A' }}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge bg-info">{{ $vehicule->type }}</span>
                    <br><small class="text-muted">{{ $vehicule->carburant }}</small>
                </td>
                <td>
                    <strong class="text-success">{{ number_format($vehicule->prix_jour, 0) }}€</strong>
                </td>
                <td>
                    @switch($vehicule->statut)
                        @case('en_attente')
                            <span class="badge bg-warning">
                                <i class="fas fa-clock"></i> En attente
                            </span>
                            @break
                        @case('disponible')
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Disponible
                            </span>
                            @break
                        @case('loue')
                            <span class="badge bg-info">
                                <i class="fas fa-key"></i> Loué
                            </span>
                            @break
                        @case('rejete')
                            <span class="badge bg-danger">
                                <i class="fas fa-times"></i> Rejeté
                            </span>
                            @break
                        @default
                            <span class="badge bg-light text-dark">{{ ucfirst($vehicule->statut) }}</span>
                    @endswitch
                </td>
                <td>
                    {{ $vehicule->created_at ? $vehicule->created_at->format('d/m/Y H:i') : 'N/A' }}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($vehicule->statut === 'en_attente')
                            <form action="{{ route('admin.vehicules.approve', $vehicule->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Approuver ce véhicule ?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm btn-action" title="Approuver">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-action" onclick="showRejectModal({{ $vehicule->id }})" title="Rejeter">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        
                        <button type="button" class="btn btn-outline-primary btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#detailModal{{ $vehicule->id }}" title="Voir détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Modal de détails -->
            <div class="modal fade" id="detailModal{{ $vehicule->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails du véhicule #{{ $vehicule->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    @if($vehicule->photo)
                                        <img src="{{ $vehicule->photo }}" alt="Photo du véhicule" class="img-fluid rounded mb-3">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                                            <i class="fas fa-car text-muted" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Informations véhicule</h6>
                                    <p><strong>Marque:</strong> {{ $vehicule->marque }}</p>
                                    <p><strong>Modèle:</strong> {{ $vehicule->modele }}</p>
                                    <p><strong>Type:</strong> {{ $vehicule->type }}</p>
                                    <p><strong>Immatriculation:</strong> {{ $vehicule->immatriculation }}</p>
                                    <p><strong>Carburant:</strong> {{ $vehicule->carburant }}</p>
                                    <p><strong>Nombre de places:</strong> {{ $vehicule->nbre_places ?? 'Non spécifié' }}</p>
                                    <p><strong>Kilométrage:</strong> {{ $vehicule->kilometrage ? number_format($vehicule->kilometrage) . ' km' : 'Non spécifié' }}</p>
                                    <p><strong>Prix par jour:</strong> <span class="text-success fw-bold">{{ number_format($vehicule->prix_jour, 0) }}€</span></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Propriétaire</h6>
                                    <p><strong>Nom:</strong> {{ $vehicule->proprietaire->nom ?? 'N/A' }} {{ $vehicule->proprietaire->prenom ?? '' }}</p>
                                    <p><strong>Email:</strong> {{ $vehicule->proprietaire->email ?? 'N/A' }}</p>
                                    <p><strong>Téléphone:</strong> {{ $vehicule->proprietaire->telephone ?? 'Non renseigné' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Autres informations</h6>
                                    <p><strong>Localisation:</strong> {{ $vehicule->localisation ?? 'Non spécifiée' }}</p>
                                    @if($vehicule->description)
                                        <p><strong>Description:</strong> {{ $vehicule->description }}</p>
                                    @endif
                                    @if($vehicule->motif_rejet)
                                        <h6 class="text-danger">Motif du rejet</h6>
                                        <p class="text-danger">{{ $vehicule->motif_rejet }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <tr>
                <td colspan="8" class="text-center py-4">
                    <i class="fas fa-car text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">Aucun véhicule trouvé pour cette catégorie.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>