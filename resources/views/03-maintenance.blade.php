<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Validation entretien</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Police et taille uniforme */
    body {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      background: linear-gradient(to right, #6aa0e5, #c0d4f5); /* bleu clair / léger */
      color: #333;
    }
   .navbar-toggler {
      border: none;
    }
    .navbar-toggler-icon {
      filter: invert(1); /* rend les 3 barres blanches */
      width: 2rem;
      height: 2rem;
    }
    .card {
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.2);
    }

    .btn-custom, .btn-success, .btn-danger {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 16px;
      border-radius: 30px;
    }

    .btn-custom {
      background: #6aa0e5;
      color: white;
    }

    .btn-custom:hover {
      background: #4f86d1;
    }

    .btn-success {
      background: #6aa0e5;
      border-color: #6aa0e5;
    }

    .btn-success:hover {
      background: #4f86d1;
      border-color: #4f86d1;
    }

    .btn-danger {
      background: #e57373;
      border-color: #e57373;
    }

    .btn-danger:hover {
      background: #d45f5f;
      border-color: #d45f5f;
    }

    h3 {
      font-family: 'Arial', Helvetica, sans-serif;
      font-size: 22px;
    }

    p {
      font-size: 16px;
    }
 
  </style>
</head>
<body>
   <div class="container d-flex justify-content-center align-items-center my-5" style="min-height:50vh;">
     @csrf 
    <div class="card p-5 w-50 text-center">
      <h3 class="mb-4 text-primary"><i class="fa-solid fa-screwdriver-wrench"></i> Entretien du véhicule</h3>
      <p>Veuillez confirmer si votre véhicule est <strong>bien entretenu</strong>.</p>
      <button id="ouiBtn" class="btn btn-success w-100 mb-3"><i class="fa-solid fa-check"></i> Oui</button>
      <button id="nonBtn" class="btn btn-danger w-100"><i class="fa-solid fa-xmark"></i> Non</button>
    </div>
  </div>

  <script>
    // Redirection selon le choix
    document.getElementById('ouiBtn').addEventListener('click', () => {
      window.location.href = "{{ route('prix') }}"; // Page suivante si Oui
    });
    document.getElementById('nonBtn').addEventListener('click', () => {
      window.location.href = "{{ route('louable') }}"; // Page suivante si Oui
    });
  </script>


</body>
</html>
