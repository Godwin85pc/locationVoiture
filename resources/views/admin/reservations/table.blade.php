<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Véhicule</th>
                <th>Période</th>
                <th>Montant</th>
                <th>Statut</th>
                <th>Date réservation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations_list as $reservation)
            <tr>
                <td>{{ $reservation->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                            {{ strtoupper(substr($reservation->client->prenom ?? 'N', 0, 1)) }}{{ strtoupper(substr($reservation->client->nom ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $reservation->client->nom ?? 'N/A' }} {{ $reservation->client->prenom ?? '' }}</strong>
                            <br><small class="text-muted">{{ $reservation->client->email ?? 'N/A' }}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <strong>{{ $reservation->vehicule->marque ?? 'N/A' }} {{ $reservation->vehicule->modele ?? '' }}</strong>
                    <br><small class="text-muted">{{ $reservation->vehicule->immatriculation ?? 'N/A' }}</small>
                </td>
                <td>
                    <strong>{{ $reservation->date_debut }}</strong>
                    <br>au <strong>{{ $reservation->date_fin }}</strong>
                    <br><small class="text-muted">
                        {{ \Carbon\Carbon::parse($reservation->date_debut)->diffInDays(\Carbon\Carbon::parse($reservation->date_fin)) + 1 }} jour(s)
                    </small>
                </td>
                <td>
                    <strong class="text-success">{{ number_format($reservation->montant_total, 0) }}€</strong>
                </td>
                <td>
                    @switch($reservation->statut)
                        @case('en_attente')
                            <span class="badge bg-warning">
                                <i class="fas fa-clock"></i> En attente
                            </span>
                            @break
                        @case('confirmee')
                            <span class="badge bg-success">
                                <i class="fas fa-check"></i> Confirmée
                            </span>
                            @break
                        @case('annulee')
                            <span class="badge bg-danger">
                                <i class="fas fa-times"></i> Annulée
                            </span>
                            @break
                        @case('terminee')
                            <span class="badge bg-secondary">
                                <i class="fas fa-flag-checkered"></i> Terminée
                            </span>
                            @break
                        @default
                            <span class="badge bg-light text-dark">{{ ucfirst($reservation->statut) }}</span>
                    @endswitch
                </td>
                <td>
                    {{ $reservation->date_reservation ? \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y H:i') : 'N/A' }}
                </td>
                <td>
                    <div class="btn-group" role="group">
                        @if($reservation->statut === 'en_attente')
                            <form action="{{ route('admin.reservations.validate', $reservation->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Confirmer cette réservation ?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-success btn-sm btn-action" title="Valider">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-outline-danger btn-sm btn-action" onclick="showRejectModal({{ $reservation->id }})" title="Rejeter">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        
                        <button type="button" class="btn btn-outline-primary btn-sm btn-action" data-bs-toggle="modal" data-bs-target="#detailModal{{ $reservation->id }}" title="Voir détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Modal de détails -->
            <div class="modal fade" id="detailModal{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Détails de la réservation #{{ $reservation->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Informations client</h6>
                                    <p><strong>Nom:</strong> {{ $reservation->client->nom ?? 'N/A' }} {{ $reservation->client->prenom ?? '' }}</p>
                                    <p><strong>Email:</strong> {{ $reservation->client->email ?? 'N/A' }}</p>
                                    <p><strong>Téléphone:</strong> {{ $reservation->client->telephone ?? 'Non renseigné' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Informations véhicule</h6>
                                    <p><strong>Véhicule:</strong> {{ $reservation->vehicule->marque ?? 'N/A' }} {{ $reservation->vehicule->modele ?? '' }}</p>
                                    <p><strong>Type:</strong> {{ $reservation->vehicule->type ?? 'N/A' }}</p>
                                    <p><strong>Immatriculation:</strong> {{ $reservation->vehicule->immatriculation ?? 'N/A' }}</p>
                                    <p><strong>Prix/jour:</strong> {{ $reservation->vehicule->prix_jour ?? 0 }}€</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Détails réservation</h6>
                                    <p><strong>Du:</strong> {{ $reservation->date_debut }}</p>
                                    <p><strong>Au:</strong> {{ $reservation->date_fin }}</p>
                                    <p><strong>Durée:</strong> {{ \Carbon\Carbon::parse($reservation->date_debut)->diffInDays(\Carbon\Carbon::parse($reservation->date_fin)) + 1 }} jour(s)</p>
                                    <p><strong>Montant total:</strong> <span class="text-success fw-bold">{{ number_format($reservation->montant_total, 0) }}€</span></p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Lieux</h6>
                                    <p><strong>Récupération:</strong> {{ $reservation->lieu_recuperation ?? 'Non spécifié' }}</p>
                                    <p><strong>Restitution:</strong> {{ $reservation->lieu_restitution ?? 'Non spécifié' }}</p>
                                    @if($reservation->motif_rejet)
                                        <h6 class="text-danger">Motif du rejet</h6>
                                        <p class="text-danger">{{ $reservation->motif_rejet }}</p>
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
                    <i class="fas fa-calendar text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">Aucune réservation trouvée pour cette catégorie.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>