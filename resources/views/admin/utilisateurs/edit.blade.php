@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit"></i> Modifier l'utilisateur
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.utilisateurs.update', $utilisateur->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-user"></i> Nom <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom', $utilisateur->nom) }}" 
                                       required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="prenom" class="form-label">
                                    <i class="fas fa-user"></i> Prénom <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('prenom') is-invalid @enderror" 
                                       id="prenom" 
                                       name="prenom" 
                                       value="{{ old('prenom', $utilisateur->prenom) }}" 
                                       required>
                                @error('prenom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $utilisateur->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">
                                <i class="fas fa-phone"></i> Téléphone
                            </label>
                            <input type="text" 
                                   class="form-control @error('telephone') is-invalid @enderror" 
                                   id="telephone" 
                                   name="telephone" 
                                   value="{{ old('telephone', $utilisateur->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="fas fa-user-tag"></i> Rôle <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">-- Sélectionner un rôle --</option>
                                <option value="client" {{ old('role', $utilisateur->role) === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="particulier" {{ old('role', $utilisateur->role) === 'particulier' ? 'selected' : '' }}>Particulier</option>
                                <option value="admin" {{ old('role', $utilisateur->role) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($utilisateur->id === auth()->id())
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> 
                                    Attention : Vous modifiez votre propre compte.
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">
                                <i class="fas fa-lock"></i> Nouveau mot de passe
                            </label>
                            <input type="password" 
                                   class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                   id="mot_de_passe" 
                                   name="mot_de_passe">
                            @error('mot_de_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Laissez vide pour conserver le mot de passe actuel.</div>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe_confirmation" class="form-label">
                                <i class="fas fa-lock"></i> Confirmer le nouveau mot de passe
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="mot_de_passe_confirmation" 
                                   name="mot_de_passe_confirmation">
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <a href="{{ route('admin.utilisateurs.show', $utilisateur->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> Voir le profil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
}
.form-control:focus, .form-select:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}
</style>
@endsection