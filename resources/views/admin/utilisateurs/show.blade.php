@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <!-- Profil utilisateur -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user"></i> Profil utilisateur
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-lg rounded-circle bg-{{ $utilisateur->role === 'admin' ? 'warning' : ($utilisateur->role === 'client' ? 'success' : 'info') }} text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                        {{ strtoupper(substr($utilisateur->prenom, 0, 1)) }}{{ strtoupper(substr($utilisateur->nom, 0, 1)) }}
                    </div>
                    <h4>{{ $utilisateur->nom }} {{ $utilisateur->prenom }}</h4>
                    <span class="badge bg-{{ $utilisateur->role === 'admin' ? 'warning' : ($utilisateur->role === 'client' ? 'success' : 'info') }} fs-6">
                        {{ ucfirst($utilisateur->role) }}
                    </span>
                    <hr>
                    <div class="text-start">
                        <p><i class="fas fa-envelope text-muted"></i> <strong>Email:</strong><br>{{ $utilisateur->email }}</p>
                        <p><i class="fas fa-phone text-muted"></i> <strong>Téléphone:</strong><br>{{ $utilisateur->telephone ?? 'Non renseigné' }}</p>
                        <p><i class="fas fa-calendar text-muted"></i> <strong>Membre depuis:</strong><br>{{ $utilisateur->created_at ? $utilisateur->created_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.utilisateurs.edit', $utilisateur->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>
                        @if($utilisateur->id !== auth()->id())
                        <form action="{{ route('admin.utilisateurs.destroy', $utilisateur->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Statistiques de l'utilisateur -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Véhicules</h6>
                                    <h3>{{ $utilisateur->vehicules()->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-car fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Réservations</h6>
                                    <h3>{{ $reservations->count() }}</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Revenus</h6>
                                    <h3>{{ number_format($totalRevenus, 0) }}€</h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-euro-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Véhicules de l'utilisateur -->
            @if($utilisateur->vehicules()->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-car"></i> Véhicules proposés ({{ $utilisateur->vehicules()->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Véhicule</th>
                                    <th>Type</th>
                                    <th>Prix/jour</th>
                                    <th>Statut</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateur->vehicules as $vehicule)
                                <tr>
                                    <td>{{ $vehicule->marque }} {{ $vehicule->modele }}</td>
                                    <td>{{ $vehicule->type }}</td>
                                    <td>{{ $vehicule->prix_jour }}€</td>
                                    <td>
                                        <span class="badge bg-{{ $vehicule->statut === 'disponible' ? 'success' : 'warning' }}">
                                            {{ ucfirst($vehicule->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('vehicules.show', $vehicule->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Réservations récentes -->
            @if($reservations->count() > 0)
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar"></i> Réservations récentes ({{ $reservations->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Véhicule</th>
                                    <th>Période</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations->take(5) as $reservation)
                                <tr>
                                    <td>{{ $reservation->vehicule->marque ?? 'N/A' }} {{ $reservation->vehicule->modele ?? '' }}</td>
                                    <td>{{ $reservation->date_debut }} au {{ $reservation->date_fin }}</td>
                                    <td>{{ $reservation->montant_total }}€</td>
                                    <td>
                                        <span class="badge bg-{{ $reservation->statut === 'confirmee' ? 'success' : ($reservation->statut === 'en_attente' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($reservation->statut) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}
</style>
@endsection