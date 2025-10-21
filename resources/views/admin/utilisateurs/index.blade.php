@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="bi bi-people me-2"></i>Utilisateurs ({{ $stats['total'] ?? 0 }})
        </h2>
        <div class="d-flex gap-2">
            <span class="badge bg-primary">Clients: {{ $stats['clients'] ?? 0 }}</span>
            <span class="badge bg-success">Particuliers: {{ $stats['particuliers'] ?? 0 }}</span>
            <span class="badge bg-danger">Admins: {{ $stats['admins'] ?? 0 }}</span>
            <span class="badge bg-secondary">Nouveaux ce mois: {{ $stats['actifs_ce_mois'] ?? 0 }}</span>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Véhicules</th>
                            <th>Réservations</th>
                            <th>Inscription</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateurs as $u)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:36px;height:36px;">
                                            {{ strtoupper(substr($u->prenom,0,1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $u->prenom }} {{ $u->nom }}</div>
                                            <small class="text-muted">#{{ $u->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $u->role === 'admin' ? 'danger' : ($u->role === 'client' ? 'primary' : 'success') }}">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td>{{ $u->vehicules_count ?? 0 }}</td>
                                <td>{{ $u->reservations_count ?? 0 }}</td>
                                <td>{{ optional($u->created_at)->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.utilisateurs.show', $u) }}" class="btn btn-outline-info" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('utilisateurs.edit', $u->id) }}" class="btn btn-outline-warning" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($u->role !== 'admin')
                                        <form action="{{ route('utilisateurs.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
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
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> Aucun utilisateur trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $utilisateurs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
