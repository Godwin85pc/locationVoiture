@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord Administrateur</h1>

    <h3>Liste des utilisateurs</h3>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#clients">Clients</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#particuliers">Particuliers</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#admins">Admins</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="clients">
            @include('admin.partials.utilisateurs', ['utilisateurs' => $clients])
        </div>
        <div class="tab-pane fade" id="particuliers">
            @include('admin.partials.utilisateurs', ['utilisateurs' => $particuliers])
        </div>
        <div class="tab-pane fade" id="admins">
            @include('admin.partials.utilisateurs', ['utilisateurs' => $admins])
        </div>
    </div>

    <h3 class="mt-5">Véhicules de l'agence</h3>
    <a href="{{ route('vehicules.create') }}" class="btn btn-success mb-3">Ajouter un véhicule</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Type</th>
                <th>Immatriculation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicules as $vehicule)
            <tr>
                <td>{{ $vehicule->marque }}</td>
                <td>{{ $vehicule->modele }}</td>
                <td>{{ $vehicule->type }}</td>
                <td>{{ $vehicule->immatriculation }}</td>
                <td>
                    <a href="{{ route('vehicules.edit', $vehicule->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection