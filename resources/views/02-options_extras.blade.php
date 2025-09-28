<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Options supplémentaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #43cea2, #185a9d); }
    .card { border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
    .form-check-label i { color: #185a9d; margin-right: 5px; }
    .btn-custom { background: #185a9d; color: white; border-radius: 30px; text-align: center; text-decoration: none; display: inline-block; padding: 10px; }
    .btn-custom:hover { background: #43cea2; color: #fff; }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card p-5 w-75">
      <h3 class="text-center mb-4 text-success">
        <i class="fa-solid fa-sliders"></i> Options supplémentaires
      </h3>
      <form>
        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="gps">
            <label class="form-check-label" for="gps"><i class="fa-solid fa-map"></i> GPS</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="siegebebe">
            <label class="form-check-label" for="siegebebe"><i class="fa-solid fa-baby-carriage"></i> Siège bébé</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="coffre">
            <label class="form-check-label" for="coffre"><i class="fa-solid fa-box"></i> Coffre de toit</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="portevelos">
            <label class="form-check-label" for="portevelos"><i class="fa-solid fa-bicycle"></i> Porte-vélos</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="pneus">
            <label class="form-check-label" for="pneus"><i class="fa-solid fa-snowflake"></i> Pneus neige</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="bluetooth">
            <label class="form-check-label" for="bluetooth"><i class="fa-solid fa-music"></i> Audio Bluetooth</label>
          </div>
        </div>

        <!-- BOUTON = LIEN -->
        <a href="{{ url('03-maintenance') }}" class="btn btn-custom w-100">
          <i class="fa-solid fa-arrow-right"></i> Suivant
        </a>
      </form>
    </div>
  </div>
</body>
</html>
