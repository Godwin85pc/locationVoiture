<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Véhicule non louable</title>
    <style>
        body {
            background-color: #f0f8ff; /* Bleu très clair (bleu ciel) */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .message-box {
            text-align: center;
            background-color: #e6f2ff; /* bleu pastel */
            border: 2px solid #3399ff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
        }

        h2 {
            color: #007acc;
            margin-bottom: 15px;
        }

        p {
            color: #333;
            font-size: 16px;
        }

        .warning {
            color: #ff3333;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="message-box">
        <h2>⚠ Véhicule non louable</h2>
        <p>Ce véhicule ne peut pas être mis en location sur notre site, car il n’est pas en bon état.</p>
        <p class="warning">Veuillez contacter l’administrateur pour une vérification.</p>
         <a href="{{ route('dashboard') }}" class="btn btn-custom mt-3">Retour au tableau de bord</a>
    </div>

</body>
</html>