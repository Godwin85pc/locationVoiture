<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prix dynamiques</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #36d1dc, #5b86e5); }
    .card { border-radius: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.25); }
    .price-box { background: white; padding: 15px; border-radius: 15px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
    .btn-circle { width: 35px; height: 35px; border-radius: 50%; font-weight: bold; }
    .btn-plus { background: #28a745; color: white; }
    .btn-minus { background: #dc3545; color: white; }
    .btn-custom { background: #5b86e5; color: white; border-radius: 30px; }
    .btn-custom:hover { background: #3c5ab8; }
    .radio-label { cursor: pointer; }
  </style>
</head>
<body>
  <div class="container py-5 d-flex justify-content-center">
    <div class="card p-5 w-75">
      <h3 class="text-center mb-4 text-primary">
        <i class="fa-solid fa-chart-line"></i> Fixer les prix dynamiques
      </h3>

      <form id="priceForm" method="POST" action="{{ route('vehicules.step4') }}">
        @csrf
        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="14"> 
            <i class="fa-solid fa-calendar-day"></i> Faible (Semaine scolaire) : <b class="price">14</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="19"> 
            <i class="fa-solid fa-calendar-week"></i> Moyenne (Week-end scolaire) : <b class="price">19</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="35"> 
            <i class="fa-solid fa-sun"></i> Forte (Vacances scolaires) : <b class="price">35</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <div class="price-box">
          <label class="radio-label">
            <input type="radio" name="prixUnique" value="48"> 
            <i class="fa-solid fa-umbrella-beach"></i> Très forte (Été - Juillet/Août) : <b class="price">48</b>€
          </label>
          <div>
            <button type="button" class="btn btn-minus btn-circle">-</button>
            <button type="button" class="btn btn-plus btn-circle">+</button>
          </div>
        </div>

        <!-- Bouton de confirmation redirige via Laravel -->
        <div class="mb-3">
          <label class="form-label">Prix retenu (€)</label>
          <input type="number" name="prix_par_jour" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-custom w-100 mt-3">
          <i class="fa-solid fa-check"></i> Enregistrer le prix et confirmer
        </button>
      </form>
    </div>
  </div>

  <script>
    // Gestion des boutons + et -
    document.querySelectorAll('.price-box').forEach(box => {
      const minus = box.querySelector('.btn-minus');
      const plus = box.querySelector('.btn-plus');
      const priceElement = box.querySelector('.price');
      
      minus.addEventListener('click', () => {
        let value = parseInt(priceElement.textContent);
        if(value > 0) priceElement.textContent = value - 1;
      });

      plus.addEventListener('click', () => {
        let value = parseInt(priceElement.textContent);
        priceElement.textContent = value + 1;
      });
    });
  </script>
</body>
</html>
