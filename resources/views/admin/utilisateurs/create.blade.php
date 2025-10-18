@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-user-plus"></i> Créer un nouvel utilisateur
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.utilisateurs.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">
                                    <i class="fas fa-user"></i> Nom <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" 
                                       name="nom" 
                                       value="{{ old('nom') }}" 
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
                                       value="{{ old('prenom') }}" 
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
                                   value="{{ old('email') }}" 
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
                                   value="{{ old('telephone') }}">
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
                                <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Client</option>
                                <option value="particulier" {{ old('role') === 'particulier' ? 'selected' : '' }}>Particulier</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe" class="form-label">
                                <i class="fas fa-lock"></i> Mot de passe <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                   id="mot_de_passe" 
                                   name="mot_de_passe" 
                                   required>
                            @error('mot_de_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Le mot de passe doit contenir au moins 6 caractères.</div>
                        </div>

                        <div class="mb-3">
                            <label for="mot_de_passe_confirmation" class="form-label">
                                <i class="fas fa-lock"></i> Confirmer le mot de passe <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="mot_de_passe_confirmation" 
                                   name="mot_de_passe_confirmation" 
                                   required>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Créer l'utilisateur
                            </button>
                            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Annuler
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
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}
</style>
@endsection