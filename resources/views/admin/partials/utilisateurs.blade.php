<table class="table table-striped">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($utilisateurs as $user)
        <tr>
            <td>{{ $user->nom }}</td>
            <td>{{ $user->prenom }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td class="text-end">
                <a href="{{ route('admin.utilisateurs.show', $user) }}" class="btn btn-info btn-sm">Voir</a>
                <a href="{{ route('utilisateurs.edit', $user->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                <form action="{{ route('utilisateurs.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>