@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4"><i class="bi bi-pencil-square me-2"></i>Modifier l'utilisateur</h2>
    <form action="{{ route('admin.utilisateurs.update', $utilisateur) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PATCH')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $utilisateur->prenom) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" value="{{ old('nom', $utilisateur->nom) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $utilisateur->email) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Téléphone</label>
                <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $utilisateur->telephone) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Rôle</label>
                <select name="role" class="form-select" required>
                    @foreach(['admin','client','particulier'] as $r)
                        <option value="{{ $r }}" @selected(old('role', $utilisateur->role) === $r)>{{ ucfirst($r) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nouveau mot de passe (optionnel)</label>
                <input type="password" name="password" class="form-control" placeholder="Laisser vide pour ne pas changer">
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-save me-2"></i>Enregistrer</button>
            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>
@endsection
