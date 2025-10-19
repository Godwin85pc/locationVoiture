<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation du véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background: linear-gradient(to right, #87ceeb, #c0e7ff);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    .container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 2rem;
    }
    .card {
      background-color: white;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 4px 25px rgba(0,0,0,0.15);
      max-width: 600px;
      width: 100%;
    }
    h2 { color: #1e90ff; margin-bottom: 1.5rem; text-align:center; }
    .prix-box {
      background-color: #e0f7ff;
      padding: 1rem 1.5rem;
      border-radius: 15px;
      margin: 1rem 0;
      text-align: center;
    }
    .prix-box h4 { color: #0077cc; margin: 0; }
    .btn-custom { background: #1e90ff; color: white; border-radius: 30px; font-size: 16px; padding: 0.75rem; }
    .btn-custom:hover { background: #0d6efd; }
    img { max-width: 100%; border-radius: 15px; margin-top: 0.5rem; }
    .update-fields { display: none; margin-top: 1rem; }
  </style>
  <script>
    function toggleUpdateFields() {
      const section = document.getElementById('update-fields');
      section.style.display = section.style.display === 'none' ? 'block' : 'none';
    }
  </script>
</head>
<body>

@php
    $vehicule = session('vehicule', [
        'marque' => 'Toyota',
        'modele' => 'Corolla',
        'type' => 'Berline',
        'carburant' => 'Essence',
        'localisation' => 'Paris',
        'prix_jour' => 200,
        'photo' => null
    ]);
@endphp

<div class="container">
  <div class="card">
    <h2>Confirmation du véhicule</h2>

    @if($vehicule)
      <p><strong>Marque :</strong> {{ $vehicule['marque'] ?? 'N/A' }}</p>
      <p><strong>Modèle :</strong> {{ $vehicule['modele'] ?? 'N/A' }}</p>
      <p><strong>Type :</strong> {{ $vehicule['type'] ?? 'N/A' }}</p>
      <p><strong>Carburant :</strong> {{ $vehicule['carburant'] ?? 'N/A' }}</p>
      <p><strong>Localisation :</strong> {{ $vehicule['localisation'] ?? '-' }}</p>

      @if(!empty($vehicule['photo']))
        <p><strong>Photo :</strong></p>
        <img src="{{ asset('storage/' . $vehicule['photo']) }}" alt="Photo du véhicule">
      @endif

      <div class="prix-box">
        <h4>Prix par jour : {{ number_format($vehicule['prix_jour'] ?? 200, 0, ',', ' ') }} €</h4>
        <small>Prix calculé automatiquement selon le type et le carburant.</small>
      </div>

      <!-- Bouton pour afficher les champs modifiables -->
      <button type="button" class="btn btn-secondary w-100 mb-3" onclick="toggleUpdateFields()">Modifier les informations</button>

      <!-- Formulaire -->
      <form action="{{ route('vehicules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div id="update-fields" class="update-fields">
          <div class="mb-3">
            <label class="form-label">Marque</label>
            <input type="text" name="marque" class="form-control" value="{{ $vehicule['marque'] ?? '' }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Modèle</label>
            <input type="text" name="modele" class="form-control" value="{{ $vehicule['modele'] ?? '' }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
              <option value="SUV" {{ ($vehicule['type'] ?? '') == 'SUV' ? 'selected' : '' }}>SUV</option>
              <option value="Berline" {{ ($vehicule['type'] ?? '') == 'Berline' ? 'selected' : '' }}>Berline</option>
              <option value="Utilitaire" {{ ($vehicule['type'] ?? '') == 'Utilitaire' ? 'selected' : '' }}>Utilitaire</option>
              <option value="Citadine" {{ ($vehicule['type'] ?? '') == 'Citadine' ? 'selected' : '' }}>Citadine</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Carburant</label>
            <select name="carburant" class="form-select">
              <option value="Essence" {{ ($vehicule['carburant'] ?? '') == 'Essence' ? 'selected' : '' }}>Essence</option>
              <option value="Diesel" {{ ($vehicule['carburant'] ?? '') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
              <option value="Electrique" {{ ($vehicule['carburant'] ?? '') == 'Electrique' ? 'selected' : '' }}>Electrique</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Localisation</label>
            <input type="text" name="localisation" class="form-control" value="{{ $vehicule['localisation'] ?? '' }}">
          </div>

          <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
          </div>
        </div>

        <!-- Champs cachés pour conserver toutes les autres valeurs -->
        @if(is_array($vehicule))
          @foreach($vehicule as $key => $value)
            @if(!in_array($key, ['marque','modele','type','carburant','localisation','photo']))
              <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
          @endforeach
        @endif
        
        <a href="{{ route('confirmation') }}" class="btn btn-custom w-100 mt-3">Confirmer et enregistrer</a>
        
      </form>

    @else
      <div class="alert alert-warning text-center">
        Aucun véhicule sélectionné.
      </div>
    @endif

  </div>
</div>

</body>
</html>