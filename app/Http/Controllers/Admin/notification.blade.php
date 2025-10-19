@extends('layouts.admin')

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
    .btn-ok {
        background: #1e90ff;
        color: white;
        border-radius: 30px;
        font-size: 16px;
        padding: 0.75rem 2rem;
        border: none;
    }
    .btn-ok:hover {
        background: #0d6efd;
    }
</style>

<div class="card">
    <h3>Nouvelle demande de location</h3>
    <p>Le loueur souhaite mettre son véhicule en location :</p>
    <p><strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong></p>

    <form action="{{ route('admin.valider_vehicule', $vehicule->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn-ok mt-3">OK</button>
    </form>
</div>
@endsection
