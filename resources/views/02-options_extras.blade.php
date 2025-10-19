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
      <form method="POST" action="{{ route('vehicules.step2') }}">
        @csrf
        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="climatisation" name="climatisation" value="1">
            <label class="form-check-label" for="climatisation"><i class="fa-solid fa-snowflake"></i> Climatisation</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="gps" name="gps" value="1">
            <label class="form-check-label" for="gps"><i class="fa-solid fa-map"></i> GPS</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="bluetooth" name="bluetooth" value="1">
            <label class="form-check-label" for="bluetooth"><i class="fa-solid fa-music"></i> Audio Bluetooth</label>
          </div>
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="sieges_chauffants" name="sieges_chauffants" value="1">
            <label class="form-check-label" for="sieges_chauffants"><i class="fa-solid fa-fire"></i> Sièges chauffants</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="toit_ouvrant" name="toit_ouvrant" value="1">
            <label class="form-check-label" for="toit_ouvrant"><i class="fa-solid fa-sun"></i> Toit ouvrant</label>
          </div>
          <div class="col-md-6 mb-3 form-check"></div>
        </div>

        <button type="submit" class="btn btn-custom w-100">
          <i class="fa-solid fa-arrow-right"></i> Suivant
        </button>
      </form>
    </div>
  </div>
</body>
</html>
