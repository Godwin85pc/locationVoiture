<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    protected $table = 'vehicules';

    protected $fillable = [
        'marque',
        'modele',
        'type',
        'immatriculation',
        'prix_jour',
        'statut',
        'carburant',
        'nbre_places',
        'localisation',
        'photo',
        'date_ajout',
        'kilometrage',
        'proprietaire_id',
        'disponible',
    ];

    public $timestamps = false;

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

    public function offres()
    {
        return $this->hasMany(OffreVehicule::class);
    }

    public function offresActives()
    {
        return $this->hasMany(OffreVehicule::class)->active();
    }

    // Accessor pour le prix par jour (utilise prix_jour)
    public function getPrixParJourAttribute()
    {
        return $this->prix_jour;
    }
}