<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tableau de bord véhicule</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f1f3f6; }
    .card { max-width: 800px; margin: auto; margin-top: 40px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white text-center">
        <h4>Résumé du véhicule</h4>
      </div>
      <div class="card-body">
        <h5>Nom du véhicule : Toyota</h5>
        <p>Immatriculation : AB-123-CD</p>
        <div class="d-flex flex-wrap gap-2">
          <!-- Bouton Modifie0r les infos -->
          <a href="{{ url('1-ajout_voiture') }}" class="btn btn-outline-primary">Modifier les infos</a>
          <!-- Autres boutons restent inchangés -->
          <button class="btn btn-outline-success">Ajouter des photos</button>
          <button class="btn btn-outline-warning">Mettre à jour calendrier</button>
          <!-- Bouton Valider l’annonce -->
          <a href="{{ url('inscrit') }}" class="btn btn-outline-danger">Valider l’annonce</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
