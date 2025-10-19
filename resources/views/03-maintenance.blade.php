<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validation entretien</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body { background: linear-gradient(to right, #43cea2, #185a9d); }
    .card { border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.2); }
    .btn-custom { background: #185a9d; color: white; border-radius: 30px; }
    .btn-custom:hover { background: #43cea2; }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-5 w-50 text-center">
      <h3 class="mb-4 text-success"><i class="fa-solid fa-screwdriver-wrench"></i> Entretien du véhicule</h3>
      <p>Veuillez confirmer si votre véhicule est <strong>bien entretenu</strong>.</p>
      <form method="POST" action="{{ route('vehicules.step3') }}">
        @csrf
        <input type="hidden" name="entretien_confirme" value="1">
        <button type="submit" class="btn btn-success w-100 mb-3">
          <i class="fa-solid fa-check"></i> Oui
        </button>
      </form>
      <form method="POST" action="{{ route('vehicules.step3') }}">
        @csrf
        <input type="hidden" name="entretien_confirme" value="0">
        <button type="submit" class="btn btn-danger w-100">
          <i class="fa-solid fa-xmark"></i> Non
        </button>
      </form>
    </div>
  </div>

  <script></script>
</body>
</html>
