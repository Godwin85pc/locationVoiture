<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avis;

class Vehicule extends Model
{
    use HasFactory;

    protected $table = 'vehicules';

    protected $fillable = [
        'proprietaire_id',
        'marque',
        'modele', 
        'annee',
        'couleur',
        'numero_plaque',
        'type',
        'immatriculation',
        'prix_jour',
        'prix_par_jour',
        'statut',
        'carburant',
        'transmission',
        'nbre_places',
        'nombre_places',
        'localisation',
        'photo',
        'kilometrage',
        'date_ajout',
        'description',
        'motif_rejet',
        'disponible',
        'climatisation',
        'gps'
    ];

    public $timestamps = true;

    protected $casts = [
        'disponible' => 'boolean',
        'climatisation' => 'boolean',
        'gps' => 'boolean',
        'date_ajout' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function avis()
    {
        return $this->hasMany(Avis::class,'vehicule_id');
    }

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

    // Accessors pour la compatibilité entre les deux conventions de noms
    public function getPrixParJourAttribute()
    {
        return $this->attributes['prix_par_jour'] ?? $this->attributes['prix_jour'];
    }

    public function getNombrePlacesAttribute()
    {
        return $this->attributes['nombre_places'] ?? $this->attributes['nbre_places'];
    }

    public function getNumeroplaqueAttribute() 
    {
        return $this->attributes['numero_plaque'] ?? $this->attributes['immatriculation'];
    }

    // Relation avec les réservations
    public function reservations()
    {
        return $this->hasMany(\App\Models\Reservation::class);
    }

    // --- Mutateurs d'écriture pour mapper les champs du formulaire vers la BDD ---
    public function setNumeroPlaqueAttribute($value)
    {
        // Mappe numero_plaque -> immatriculation
        $this->attributes['immatriculation'] = $value;
    }

    public function setPrixParJourAttribute($value)
    {
        // Mappe prix_par_jour -> prix_jour
        $this->attributes['prix_jour'] = $value;
    }

    public function setNombrePlacesAttribute($value)
    {
        // Mappe nombre_places -> nbre_places
        $this->attributes['nbre_places'] = $value;
    }
}