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
        <h4>Prix par jour : {{ number_format($vehicule['prix_jour'], 0, ',', ' ') }} FCFA</h4>
        <small>Prix calculé automatiquement selon le type et le carburant.</small>
      </div>

      <form action="{{ route('vehicules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="marque" value="{{ $vehicule['marque'] }}">
        <input type="hidden" name="modele" value="{{ $vehicule['modele'] }}">
        <input type="hidden" name="type" value="{{ $vehicule['type'] }}">
        <input type="hidden" name="carburant" value="{{ $vehicule['carburant'] }}">
        <input type="hidden" name="localisation" value="{{ $vehicule['localisation'] }}">
        <input type="hidden" name="prix_jour" value="{{ $vehicule['prix_jour'] }}">
        @if($vehicule['photo'] ?? false)
          <input type="hidden" name="photo" value="{{ $vehicule['photo'] }}">
        @endif

        <button type="submit" class="btn btn-custom w-100 mt-3">
          Confirmer et enregistrer
        </button>
         <!-- 🔽 Nouvelle section : Formulaire de modification -->
      <div class="update-section">
        <h4 class="text-center text-primary mb-3">
          <i class="fa-solid fa-pen-to-square"></i> Modifier les informations du véhicule
        </h4>

        <form action="{{ route('vehicules.update', $vehicule->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          

   <input type="hidden" name="proprietaire_id" value="{{ $vehicule['proprietaire_id'] }}">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-building"></i> Marque</label>
                    <input type="text" name="marque" class="form-control" value="{{ $vehicule['marque'] }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-car"></i> Modèle</label>
                    <input type="text" name="modele" class="form-control" value="{{ $vehicule['modele'] }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="statut" class="form-label">Statut du véhicule :</label>
                <select name="statut" id="statut" class="form-select" required>
                    <option value="disponible" {{ $vehicule['statut'] == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="reserve" {{ $vehicule['statut'] == 'reserve' ? 'selected' : '' }}>Réservé</option>
                    <option value="en_location" {{ $vehicule['statut'] == 'en_location' ? 'selected' : '' }}>En location</option>
                    <option value="maintenance" {{ $vehicule['statut'] == 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-euro-sign"></i> Prix journalier (€)</label>
                    <input type="number" name="prix_jour" class="form-control" value="{{ $vehicule['prix_jour'] }}" step="0.01" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-calendar-plus"></i> Date d’ajout</label>
                    <input type="date" name="date_ajout" class="form-control" value="{{ $vehicule['date_ajout'] }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-hashtag"></i> Immatriculation</label>
                    <input type="text" name="immatriculation" class="form-control" value="{{ $vehicule['immatriculation'] }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-location-dot"></i> Localisation</label>
                    <input type="text" name="localisation" class="form-control" value="{{ $vehicule['localisation'] }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-gas-pump"></i> Carburant</label>
                    <select name="carburant" class="form-select" required>
                        <option value="Essence" {{ $vehicule['carburant'] == 'Essence' ? 'selected' : '' }}>Essence</option>
                        <option value="Diesel" {{ $vehicule['carburant'] == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Hybride" {{ $vehicule['carburant'] == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="Électrique" {{ $vehicule['carburant'] == 'Électrique' ? 'selected' : '' }}>Électrique</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-users"></i> Nombre de places</label>
                    <input type="number" name="nbre_places" class="form-control" value="{{ $vehicule['nbre_places'] }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-gauge-high"></i> Kilométrage</label>
                    <input type="number" name="kilometrage" class="form-control" value="{{ $vehicule['kilometrage'] }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label"><i class="fa-solid fa-car"></i> Type</label>
                    <select name="type" class="form-select" required>
                        <option value="SUV" {{ $vehicule['type'] == 'SUV' ? 'selected' : '' }}>SUV</option>
                        <option value="Berline" {{ $vehicule['type'] == 'Berline' ? 'selected' : '' }}>Berline</option>
                        <option value="Utilitaire" {{ $vehicule['type'] == 'Utilitaire' ? 'selected' : '' }}>Utilitaire</option>
                        <option value="Citadine" {{ $vehicule['type'] == 'Citadine' ? 'selected' : '' }}>Citadine</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label"><i class="fa-solid fa-image"></i> Photo du véhicule</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                    <small class="text-muted">Formats acceptés : JPG, PNG, JPEG</small>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success w-50">
                    <i class="fa-solid fa-check"></i> OK
                </button>
            </div>
      </form>
    </div>
  </div>
</body>
</html>
