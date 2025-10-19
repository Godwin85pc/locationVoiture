<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informations véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5);
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 0;
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
      max-width: 800px;
      width: 100%;
    }

    .form-control, .form-select {
      border-radius: 10px;
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
    }

    .btn-custom {
      background: #6aa0e5;
      color: white;
      border-radius: 30px;
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
    }

    .btn-custom:hover {
      background: #4f86d1;
    }

    label i {
      color: #6aa0e5;
      margin-right: 5px;
    }

    footer {
      background-color: #212529;
      color: white;
      margin-top: auto;
    }

    .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1);
      width: 2rem;
      height: 2rem;
    }
  </style>
  @php($errors = $errors ?? session('errors'))
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-light" style="background-color:#6aa0e5;">
    <a class="navbar-brand text-white" href="#">LocationVoiture</a>
    <div class="dropdown ms-auto">
      <button class="navbar-toggler" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
        <li><a class="dropdown-item" href="#">À propos</a></li>
        <li><a class="dropdown-item" href="{{ route('login') }}">Louer ma voiture</a></li>
      </ul>
    </div>
  </nav>

  <!-- Contenu principal -->
  <main>
    <div class="card p-5">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-car-side"></i> Informations du véhicule
      </h3>

      @if($errors && $errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- ✅ Formulaire sécurisé -->
      <form action="{{ route('vehicules.step1') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-building"></i> Marque</label>
            <input type="text" name="marque" class="form-control" placeholder="Ex: Toyota" value="{{ old('marque') }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-car"></i> Modèle</label>
            <input type="text" name="modele" class="form-control" placeholder="Ex: Corolla" value="{{ old('modele') }}" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-hashtag"></i> Immatriculation</label>
            <input type="text" name="immatriculation" class="form-control" placeholder="Ex: AB-123-CD" value="{{ old('immatriculation') }}" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-location-dot"></i> Localisation</label>
            <input type="text" name="localisation" class="form-control" placeholder="Ex: Paris, République" value="{{ old('localisation') }}" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-car"></i> Type</label>
            <select name="type" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="SUV" {{ old('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
              <option value="Berline" {{ old('type') == 'Berline' ? 'selected' : '' }}>Berline</option>
              <option value="Utilitaire" {{ old('type') == 'Utilitaire' ? 'selected' : '' }}>Utilitaire</option>
              <option value="Citadine" {{ old('type') == 'Citadine' ? 'selected' : '' }}>Citadine</option>
            </select>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gas-pump"></i> Carburant</label>
            <select name="carburant" class="form-select" required>
              <option value="">-- Choisir --</option>
              <option value="Essence" {{ old('carburant') == 'Essence' ? 'selected' : '' }}>Essence</option>
              <option value="Diesel" {{ old('carburant') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
              <option value="Electrique" {{ old('carburant') == 'Electrique' ? 'selected' : '' }}>Électrique</option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-users"></i> Nombre de places</label>
            <input type="number" name="nbre_places" class="form-control" placeholder="Ex: 5" value="{{ old('nbre_places', 4) }}" min="2" max="9" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="fa-solid fa-gauge-high"></i> Kilométrage</label>
            <input type="number" name="kilometrage" class="form-control" placeholder="Ex: 50000" value="{{ old('kilometrage', 0) }}" min="0" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label"><i class="fa-solid fa-image"></i> Photo du véhicule</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            <small class="text-muted">Formats acceptés : JPG, PNG, JPEG (optionnel)</small>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 mb-3">
            <label class="form-label"><i class="fa-solid fa-comment"></i> Description</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Décrivez votre véhicule...">{{ old('description') }}</textarea>
          </div>
        </div>

        <!-- Note sur le prix automatique -->
        <div class="alert alert-info">
          <i class="fa-solid fa-info-circle"></i> 
          <strong>Prix automatique :</strong> Le prix par jour sera calculé automatiquement selon le type de véhicule (SUV: 250€, Berline: 200€, Utilitaire: 300€, Citadine: 150€).
        </div>

        <button type="submit" class="btn btn-custom w-100">
          <i class="fa-solid fa-paper-plane"></i> Suivant
        </button>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container py-4">
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <h5>LocationVoiture</h5>
          <p>Le meilleur choix pour votre location de véhicule.</p>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <h5>Contact</h5>
          <p>123 Avenue de Paris, France</p>
          <p>+33 1 23 45 67 89</p>
          <p>info@locationvoiture.fr</p>
        </div>
        <div class="col-md-4">
          <h5>Newsletter</h5>
          <div class="input-group">
            <input type="email" class="form-control" placeholder="Votre email">
            <button class="btn btn-primary">S'abonner</button>
          </div>
        </div>
      </div>
      <hr class="bg-light">
      <div class="text-center">&copy; 2025 LocationVoiture. Tous droits réservés.</div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
