<div style="background-color: #cceeff; padding: 30px; text-align: center; font-family: Arial, sans-serif; border-radius: 10px;">
    <h3 style="color: #0077cc;">Félicitations !</h3>
    <p style="font-size: 16px; color: #005fa3;">
        Votre véhicule <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong> a été validé pour la location.
    </p>
    <p style="font-size: 14px; color: #005fa3;">
        Vous pouvez maintenant le mettre à disposition des locataires.
    </p>
</div>
<div style="background-color: #cceeff; padding: 30px; text-align: center; font-family: Arial, sans-serif; border-radius: 10px;">
    <h3 style="color: #0077cc;">Félicitations !</h3>
    <p style="font-size: 16px; color: #005fa3;">
        Votre véhicule <strong>{{ $vehicule->marque }} {{ $vehicule->modele }}</strong> a été validé pour la location.
    </p>
    <p style="font-size: 14px; color: #005fa3;">
        Vous pouvez maintenant le mettre à disposition des locataires.
    </p>
    
    <div style="margin: 20px 0; padding: 15px; background-color: #e6f3ff; border-radius: 8px;">
        <h4 style="color: #0066cc; margin: 0 0 10px 0;">Détails du véhicule :</h4>
        <p style="margin: 5px 0;"><strong>Type :</strong> {{ ucfirst($vehicule->type) }}</p>
        <p style="margin: 5px 0;"><strong>Immatriculation :</strong> {{ $vehicule->numero_plaque ?? $vehicule->immatriculation }}</p>
        <p style="margin: 5px 0;"><strong>Prix/jour :</strong> {{ number_format($vehicule->prix_par_jour ?? $vehicule->prix_jour, 0, ',', ' ') }} €</p>
    </div>

    <div style="margin-top: 25px;">
        <a href="{{ route('vehicules.show', $vehicule->id) }}" 
           style="background-color: #0077cc; color: white; padding: 12px 25px; text-decoration: none; border-radius: 25px; font-weight: bold;">
            🚗 Voir mon véhicule
        </a>
    </div>
</div>