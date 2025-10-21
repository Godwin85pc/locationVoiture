@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #87ceeb, #c0e7ff);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: Arial, sans-serif;
    }
    .card {
        background: #ffffffdd;
        padding: 2rem;
        border-radius: 20px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.15);
        text-align: center;
        max-width: 500px;
        width: 100%;
    }
    .btn-custom {
        background: #1e90ff;
        color: white;
        border-radius: 30px;
        font-size: 16px;
        padding: 0.75rem 2rem;
        border: none;
    }
    .btn-custom:hover {
        background: #0d6efd;
    }
    .icon-success {
        color: #28a745;
        font-size: 4rem;
        margin-bottom: 1rem;
    }
</style>

<div class="card">
    <div class="icon-success">
        <i class="fas fa-check-circle"></i>
    </div>
    <h3 class="text-success">Véhicule soumis avec succès !</h3>
    <p class="text-muted mb-4">
        Votre véhicule a été envoyé à notre équipe pour validation. 
        Vous recevrez un email de confirmation une fois votre véhicule validé pour la location.
    </p>
    
    <div class="alert alert-info text-start">
        <h6><i class="fas fa-info-circle me-2"></i>Prochaines étapes :</h6>
        <ul class="mb-0 small">
            <li>Notre équipe va vérifier les informations</li>
            <li>Vous recevrez un email de validation</li>
            <li>Votre véhicule sera alors disponible à la location</li>
        </ul>
    </div>
    
    <div class="d-grid gap-2">
        <form action="" method="POST">
            @csrf
            
        </form>
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary">
            <i class="fas fa-tachometer-alt me-2"></i>Retour au tableau de bord
        </a>
        <a href="{{ route('vehicules.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-car me-2"></i>Mes véhicules
        </a>
    </div>
</div>
@endsection