@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bi bi-person-badge me-2"></i>Détails utilisateur
        </h2>
        <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width:48px;height:48px;">
                            {{ strtoupper(substr($utilisateur->prenom,0,1)) }}
                        </div>
                        <div>
                            <div class="h5 mb-0">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</div>
                            <small class="text-muted">#{{ $utilisateur->id }}</small>
                        </div>
                    </div>
                    <div class="mb-2"><i class="bi bi-envelope me-2"></i>{{ $utilisateur->email }}</div>
                    @if($utilisateur->telephone)
                    <div class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $utilisateur->telephone }}</div>
                    @endif
                    <div class="mb-2">
                        <i class="bi bi-person-badge me-2"></i>
                        <span class="badge bg-{{ $utilisateur->role === 'admin' ? 'danger' : ($utilisateur->role === 'client' ? 'primary' : 'success') }}">{{ ucfirst($utilisateur->role) }}</span>
                    </div>
                    <div class="mb-2"><i class="bi bi-calendar me-2"></i>Inscrit le {{ optional($utilisateur->created_at)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white"><strong>Résumé</strong></div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col">
                                    <div class="h4 mb-0">{{ $utilisateur->vehicules_count ?? 0 }}</div>
                                    <small class="text-muted">Véhicules</small>
                                </div>
                                <div class="col">
                                    <div class="h4 mb-0">{{ $utilisateur->reservations_count ?? 0 }}</div>
                                    <small class="text-muted">Réservations</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white"><strong>Derniers véhicules</strong></div>
                        <div class="card-body">
                            @forelse($utilisateur->vehicules as $v)
                                <div class="mb-2">
                                    <i class="bi bi-car-front me-2"></i>{{ $v->marque }} {{ $v->modele }} — <small class="text-muted">{{ optional($v->created_at)->format('d/m/Y') }}</small>
                                </div>
                            @empty
                                <div class="text-muted">Aucun véhicule récent.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white"><strong>Dernières réservations</strong></div>
                        <div class="card-body">
                            @forelse($utilisateur->reservations as $r)
                                <div class="mb-2">
                                    <i class="bi bi-calendar-check me-2"></i>{{ optional($r->date_debut)->format('d/m/Y') }} → {{ optional($r->date_fin)->format('d/m/Y') }} — <small class="text-muted">Statut: {{ $r->statut }}</small>
                                </div>
                            @empty
                                <div class="text-muted">Aucune réservation récente.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
