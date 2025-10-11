<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du véhicule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f9f9f9; }
        .pack-badge { background-color: #198754; color: white; border-radius: 20px; padding: 3px 10px; font-size: 0.85rem; margin-right: 5px; }
        .btn-reserver { background-color: #007bff; color: white; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary px-3">
    <a class="navbar-brand text-white" href="{{ route('voiture2') }}">LocationCar</a>
</nav>

<div class="container mt-4">
    <div class="text-center mb-3">
        <img src="{{ $vehicule->photo ? asset($vehicule->photo) : 'https://via.placeholder.com/500x250' }}" class="img-fluid rounded mb-3">
        <h4>{{ $vehicule->marque }} {{ $vehicule->modele }}</h4>
        <p class="text-muted">{{ ucfirst($vehicule->type) }} - {{ ucfirst($vehicule->statut ?? 'Disponible') }}</p>
    </div>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Carburant :</strong> {{ $vehicule->carburant }}</li>
        <li class="list-group-item"><strong>Transmission :</strong> {{ $vehicule->transmission ?? 'Automatique' }}</li>
        <li class="list-group-item"><strong>Kilométrage :</strong> {{ $vehicule->kilometrage ?? 0 }} km</li>
        <li class="list-group-item"><strong>Prix :</strong> {{ $vehicule->prix_jour }} €/jour</li>
    </ul>

    <!-- Packs -->
    <div class="mb-3">
        <strong>Packs :</strong>
        @if(!empty($vehicule->packs))
            @foreach(is_array($vehicule->packs) ? $vehicule->packs : json_decode($vehicule->packs, true) as $pack)
                <span class="pack-badge">{{ is_array($pack) ? ($pack['nom'] ?? 'Pack') : $pack }}</span>
            @endforeach
        @else
            <span class="text-muted">Aucun pack disponible</span>
        @endif
    </div>

    <!-- Moyenne des avis -->
    @php
        $noteMoyenne = $vehicule->avis->avg('note') ?? 0;
    @endphp
    <p><strong>Note moyenne :</strong> 
        @if($noteMoyenne > 0)
            {{ number_format($noteMoyenne, 1) }}/5
        @else
            <span class="text-muted">Aucune note</span>
        @endif
    </p>

    <!-- Liste des avis -->
    <div class="mb-4">
        <h5>Avis :</h5>
        @forelse($vehicule->avis as $avis)
            <div class="border p-2 mb-2 rounded">
                <strong>{{ $avis->auteur ?? 'Anonyme' }}</strong> :
                {{ $avis->commentaire }} ({{ $avis->note }}/5)
            </div>
        @empty
            <p class="text-muted">Aucun avis pour ce véhicule.</p>
        @endforelse
    </div>

    <!-- Formulaire pour ajouter un avis -->
    <div class="mb-4">
        <h5>Laisser un avis</h5>
        <form method="POST" action="{{ route('avis.store', $vehicule->id) }}">
            @csrf
            <div class="mb-2">
                <input type="text" name="auteur" class="form-control" placeholder="Votre nom (optionnel)">
            </div>
            <div class="mb-2">
                <textarea name="commentaire" class="form-control" placeholder="Votre avis" required></textarea>
            </div>
            <div class="mb-2">
                <select name="note" class="form-select" required>
                    <option value="">Sélectionnez une note</option>
                    @for($i=1; $i<=5; $i++)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Publier</button>
        </form>
    </div>

    <!-- Bouton Réserver -->
    <a href="{{ route('reservation', ['id' => $vehicule->id]) }}" class="btn btn-reserver">Réserver ce véhicule</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
