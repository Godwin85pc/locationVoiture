<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Avis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'date_ajout',
        'description',
        'motif_rejet',
        'disponible',
        'climatisation',
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

    // URL normalisée de la photo (prend en charge URL externe, chemin Storage, ou vide)
    public function getPhotoUrlAttribute()
    {
        $photo = $this->photo ?? '';

        if (!$photo || trim($photo) === '') {
            return 'https://via.placeholder.com/400x200?text=Véhicule';
        }

        // Si déjà une URL absolue (http/https), retourner telle quelle
        if (Str::startsWith($photo, ['http://', 'https://'])) {
            return $photo;
        }

        // Si commence par /storage ou storage -> asset direct
        if (Str::startsWith($photo, ['/storage/', 'storage/'])) {
            return asset(ltrim($photo, '/'));
        }

        // Dans les autres cas, considérer que c'est un chemin sur le disque public
        return Storage::url($photo);
    }

    // Pour compatibilité éventuelle avec un ancien nom d'attribut
    public function getImageUrlAttribute()
    {
        return $this->photo_url;
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
        return $this->attributes['nbre_places'] ?? $this->attributes['nbre_places'];
    }

    public function getImmatriculationAttribute() 
    {
        return $this->attributes['immatriculation'] ?? $this->attributes['immatriculation'];
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