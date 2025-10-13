<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Date création</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm rounded-circle bg-{{ $user->role === 'admin' ? 'warning' : ($user->role === 'client' ? 'success' : 'info') }} text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                            {{ strtoupper(substr($user->prenom, 0, 1)) }}{{ strtoupper(substr($user->nom, 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $user->nom }} {{ $user->prenom }}</strong>
                        </div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->telephone ?? 'Non renseigné' }}</td>
                <td>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'warning' : ($user->role === 'client' ? 'success' : 'info') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.utilisateurs.show', $user->id) }}" class="btn btn-outline-primary btn-sm btn-action">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.utilisateurs.edit', $user->id) }}" class="btn btn-outline-warning btn-sm btn-action">
                            <i class="fas fa-edit"></i>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.utilisateurs.destroy', $user->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm btn-action">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        @else
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-action" disabled title="Vous ne pouvez pas vous supprimer">
                            <i class="fas fa-ban"></i>
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4">
                    <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">Aucun utilisateur trouvé pour cette catégorie.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>