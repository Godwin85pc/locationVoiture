@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Détails du véhicule</h2>

    <div class="card mb-4">
        <img src="{{ asset('storage/' . $vehicule->image) }}" class="card-img-top" alt="{{ $vehicule->nom }}" style="max-height:400px;object-fit:cover;">
        <div class="card-body">
            <h4 class="card-title">{{ $vehicule->nom }}</h4>
            <p><strong>Marque :</strong> {{ $vehicule->marque }}</p>
            <p><strong>Prix :</strong> {{ $vehicule->prix }} €</p>
            <p><strong>Description :</strong> {{ $vehicule->description }}</p>

            <hr>
            <h5>Note moyenne : 
                @php
                    $moyenne = round($vehicule->moyenneAvis() ?? 0, 1);
                @endphp
                <span class="text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $moyenne)
                            ★
                        @else
                            ☆
                        @endif
                    @endfor
                </span>
                ({{ $moyenne }}/5)
            </h5>
        </div>
    </div>

    {{-- Liste des avis --}}
    <h4 class="mt-5">Avis des utilisateurs</h4>
    @forelse ($vehicule->avis as $avis)
        <div class="border p-3 mb-3 rounded shadow-sm">
            <strong>{{ $avis->nom_utilisateur }}</strong> - 
            <span class="text-warning">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $avis->note)
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </span>
            <p>{{ $avis->commentaire }}</p>
        </div>
    @empty
        <p>Aucun avis pour ce véhicule pour le moment.</p>
    @endforelse

    {{-- Formulaire d'avis --}}
<div class="mt-5">
    <h4>Laisser un avis</h4>

    @auth
        <form method="POST" action="{{ route('vehicules.storeAvis', $vehicule->id) }}">
            @csrf
            {{-- Nom utilisateur pré-rempli avec Auth --}}
            <input type="hidden" name="nom_utilisateur" value="{{ Auth::user()->name }}">

            <div class="mb-3">
                <label for="note">Note (1 à 5)</label>
                <select name="note" id="note" class="form-select" required>
                    <option value="">Choisir...</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="mb-3">
                <label for="commentaire">Commentaire</label>
                <textarea name="commentaire" id="commentaire" class="form-control" rows="3" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Publier mon avis</button>
        </form>
    @else
        <p>Vous devez être <a href="{{ route('login') }}">connecté</a> pour laisser un avis.</p>
    @endauth
</div>
</div>
@endsection
