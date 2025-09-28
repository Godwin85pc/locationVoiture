<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tarification</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #e9f7ef; }
    .card { max-width: 700px; margin: auto; margin-top: 40px; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card shadow-lg">
      <div class="card-header bg-success text-white text-center">
        <h4>Définissez vos prix</h4>
      </div>
      <div class="card-body">
        <p>
          Vous définissez un prix par jour. Nous calculons le prix de réservation basé sur vos tarifs
          et incluons les frais d’assurance. Nous déduisons <b>10% de frais de service</b>. 
          Vous êtes indemnisé pour les frais supplémentaires (carburant manquant, pénalités...).
        </p>
        
        <!-- Ici, on redirige vers la route Laravel -->
        <form action="{{ route('05-set_prices') }}" method="GET">
          <div class="mb-3">
            <label class="form-label">Prix par jour (€)</label>
            <input type="number" class="form-control" placeholder="Ex: 30" required>
          </div>
          <button type="submit" class="btn btn-success w-100">
            Fixer les prix de location
          </button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
