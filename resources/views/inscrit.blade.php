<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Inscription</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #43cea2, #185a9d);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 25px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      width: 100%;
      max-width: 500px;
      min-width: 280px;
      background: #ffffffdd;
      padding: 2rem;
    }
    h3 {
      color: #185a9d;
      font-weight: bold;
    }
    .btn-success {
      border-radius: 30px;
      font-weight: bold;
      background: #185a9d;
      border: none;
    }
    .btn-success:hover {
      background: #43cea2;
      color: white;
    }
    .text-center a {
      color: #185a9d;
      font-weight: bold;
      text-decoration: none;
    }
    .text-center a:hover {
      color: #43cea2;
    }
    .input-group select {
      border-top-left-radius: 0.375rem;
      border-bottom-left-radius: 0.375rem;
    }
  </style>
</head>
<body>

  <div class="card shadow-lg">
    <h3 class="text-center mb-4">Inscription</h3>

    <form>

      <!-- Nom -->
      <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="nom" placeholder="Votre nom" required />
      </div>

      <!-- Prénom -->
      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom</label>
        <input type="text" class="form-control" id="prenom" placeholder="Votre prénom" required />
      </div>

      <!-- Téléphone avec indicatif -->
      <div class="mb-3">
        <label class="form-label">Numéro de téléphone</label>
        <div class="input-group">
          <select class="form-select" style="max-width: 120px;" required>
            <option selected disabled>Indicatif</option>
            <option value="+33">🇫🇷 +33 (France)</option>
            <option value="+225">🇨🇮 +225 (Côte d'Ivoire)</option>
            <option value="+229">🇧🇯 +229 (Bénin)</option>
            <option value="+237">🇨🇲 +237 (Cameroun)</option>
            <option value="+1">🇺🇸 +1 (USA)</option>
          </select>
          <input type="tel" class="form-control" placeholder="Numéro de téléphone" required />
        </div>
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label">Adresse e-mail</label>
        <input type="email" class="form-control" id="email" placeholder="exemple@mail.com" required />
      </div>

      <!-- Mot de passe -->
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" id="password" placeholder="Votre mot de passe" required />
      </div>

      <!-- Confirmation mot de passe -->
      <div class="mb-4">
        <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
        <input type="password" class="form-control" id="confirmPassword" placeholder="Répétez le mot de passe" required />
      </div>

      <!-- Bouton Valider -->
      <div class="d-grid">
        <button type="submit" class="btn btn-success">Valider</button>
      </div>

    </form>

    <!-- Lien Se connecter avec redirection Laravel -->
    <p class="text-center mt-3 mb-0">
      vous avez déjà un compte ? 
      <a href="{{ route('connection') }}">Se connecter</a>
    </p>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
