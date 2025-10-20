<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';

    protected $fillable = [
        'proprietaire_id',
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
        'kilometrage',
        'proprietaire_id',
        'disponible',
        'description',
        'motif_rejet'
    ];

    public $timestamps = false;

    // Relation avec l'utilisateur propriétaire
    public function proprietaire()
    {
        return $this->belongsTo(\App\Models\Utilisateur::class, 'proprietaire_id');
    }

    // Pour la compatibilité avec votre dashboard
    public function getImageUrlAttribute()
    {
        return $this->photo ?? 'https://via.placeholder.com/400x200?text=Véhicule';
    }

    public function offres()
    {
        return $this->hasMany(OffreVehicule::class);
    }

    public function offresActives()
    {
        return $this->hasMany(OffreVehicule::class)->active();
    }

    // Accessor pour le prix par jour 
    public function getPrixParJourAttribute()
    {
        return $this->prix_jour;
    }
}