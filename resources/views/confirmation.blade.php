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
</style>

<div class="card">
    <h3>Véhicule soumis avec succès !</h3>
    <p>Vous recevrez un mail si votre véhicule est validé pour la location.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-custom mt-3">Retour au tableau de bord</a>
</div>
@endsection
