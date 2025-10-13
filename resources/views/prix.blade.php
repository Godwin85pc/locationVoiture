<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Prix du véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Fond bleu ciel dégradé et police moderne */
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

    h2 {
      color: #1e90ff;
      margin-bottom: 1.5rem;
    }

    p {
      font-size: 16px;
      margin-bottom: 0.8rem;
    }

    .prix-box {
      background-color: #e0f7ff;
      padding: 1rem 1.5rem;
      border-radius: 15px;
      margin: 1rem 0;
      text-align: center;
    }

    .prix-box h4 {
      color: #0077cc;
      margin: 0;
    }

    .btn-custom {
      background: #1e90ff;
      color: white;
      border-radius: 30px;
      font-size: 16px;
      padding: 0.75rem;
    }

    .btn-custom:hover {
      background: #0d6efd;
    }

    img {
      max-width: 100%;
      border-radius: 15px;
      margin-top: 0.5rem;
    }

    small {
      color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2 class="text-center">Confirmation du véhicule</h2>

      <p><strong>Marque :</strong> {{ $vehicule['marque'] }}</p>
      <p><strong>Modèle :</strong> {{ $vehicule['modele'] }}</p>
      <p><strong>Type :</strong> {{ $vehicule['type'] }}</p>
      <p><strong>Carburant :</strong> {{ $vehicule['carburant'] }}</p>
      <p><strong>Localisation :</strong> {{ $vehicule['localisation'] ?? '-' }}</p>

      @if($vehicule['photo'] ?? false)
        <p><strong>Photo :</strong></p>
        <img src="{{ asset('storage/' . $vehicule['photo']) }}" alt="Photo du véhicule">
      @endif

      <div class="prix-box">
        <h4>Prix par jour : {{ number_format($prix, 0, ',', ' ') }} FCFA</h4>
        <small>Prix calculé automatiquement selon le type et le carburant.</small>
      </div>

      <form action="{{ route('vehicules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="marque" value="{{ $vehicule['marque'] }}">
        <input type="hidden" name="modele" value="{{ $vehicule['modele'] }}">
        <input type="hidden" name="type" value="{{ $vehicule['type'] }}">
        <input type="hidden" name="carburant" value="{{ $vehicule['carburant'] }}">
        <input type="hidden" name="localisation" value="{{ $vehicule['localisation'] }}">
        <input type="hidden" name="prix_jour" value="{{ $prix }}">
        @if($vehicule['photo'] ?? false)
          <input type="hidden" name="photo" value="{{ $vehicule['photo'] }}">
        @endif

        <button type="submit" class="btn btn-custom w-100 mt-3">
          Confirmer et enregistrer
        </button>
      </form>
    </div>
  </div>
</body>
</html>
