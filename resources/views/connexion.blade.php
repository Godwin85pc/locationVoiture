<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body class="bg-light">

  <div
    class="container d-flex justify-content-center align-items-center"
    style="min-height: 100vh"
  >
    <div
      class="p-5 rounded shadow bg-light"
      style="width: 100%; max-width: 400px; min-width: 280px"
    >
      <!-- Étape 1 : Choix client ou particulier -->
      <div id="choixType">
        <h4 class="text-center mb-4">Vous êtes :</h4>
        <div class="d-grid gap-3">
          <button
            class="btn btn-primary"
            onclick="afficherFormulaire('client')"
            type="button"
          >
            Client
          </button>
          <button
            class="btn btn-secondary"
            onclick="afficherFormulaire('particulier')"
            type="button"
          >
            Particulier
          </button>
        </div>
      </div>

      <!--  Formulaire de connexion -->
      <div id="formConnexion" style="display: none;">
        <h3 class="text-center mb-4" id="titreForm">Connexion</h3>

        <form method="POST" action="{{ route('01-ajout_voiture') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input
              type="email"
              class="form-control"
              id="email"
              placeholder="nom@example.com"
              required
            />
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input
              type="password"
              class="form-control"
              id="password"
              placeholder="Votre mot de passe"
              required
            />
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Se connecter</button>
          </div>
        </form>

        <p class="text-center mt-3 mb-0">
          Mot de passe oublié ? <a href="#">Cliquez ici</a>
        </p>
      </div>
    </div>
  </div>

  <!-- ✅ Script pour afficher le bon formulaire -->
  <script>
    function afficherFormulaire(type) {
      document.getElementById("choixType").style.display = "none";
      document.getElementById("formConnexion").style.display = "block";

      const titre = document.getElementById("titreForm");
      if (type === "client") {
        titre.textContent = "Connexion Client";
      } else {
        titre.textContent = "Connexion Particulier";
      }
    }
  </script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
