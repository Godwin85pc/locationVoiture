@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary">
            <i class="fas fa-users"></i> Gestion des Utilisateurs
        </h1>
        <a href="{{ route('admin.utilisateurs.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Utilisateurs</h6>
                            <h3>{{ $utilisateurs->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Clients</h6>
                            <h3>{{ $utilisateurs->where('role', 'client')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Particuliers</h6>
                            <h3>{{ $utilisateurs->where('role', 'particulier')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Admins</h6>
                            <h3>{{ $utilisateurs->where('role', 'admin')->count() }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres par rôle -->
    <ul class="nav nav-tabs mb-3" id="userTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tous-tab" data-bs-toggle="tab" data-bs-target="#tous" type="button" role="tab">
                Tous ({{ $utilisateurs->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="clients-tab" data-bs-toggle="tab" data-bs-target="#clients" type="button" role="tab">
                Clients ({{ $utilisateurs->where('role', 'client')->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="particuliers-tab" data-bs-toggle="tab" data-bs-target="#particuliers" type="button" role="tab">
                Particuliers ({{ $utilisateurs->where('role', 'particulier')->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="admins-tab" data-bs-toggle="tab" data-bs-target="#admins" type="button" role="tab">
                Admins ({{ $utilisateurs->where('role', 'admin')->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="userTabsContent">
        <!-- Tous les utilisateurs -->
        <div class="tab-pane fade show active" id="tous" role="tabpanel">
            @include('admin.utilisateurs.table', ['users' => $utilisateurs])
        </div>
        
        <!-- Clients -->
        <div class="tab-pane fade" id="clients" role="tabpanel">
            @include('admin.utilisateurs.table', ['users' => $utilisateurs->where('role', 'client')])
        </div>
        
        <!-- Particuliers -->
        <div class="tab-pane fade" id="particuliers" role="tabpanel">
            @include('admin.utilisateurs.table', ['users' => $utilisateurs->where('role', 'particulier')])
        </div>
        
        <!-- Admins -->
        <div class="tab-pane fade" id="admins" role="tabpanel">
            @include('admin.utilisateurs.table', ['users' => $utilisateurs->where('role', 'admin')])
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.table th {
    background-color: #f8f9fa;
    border-top: none;
}

.btn-action {
    margin: 0 2px;
}
</style>
@endsection