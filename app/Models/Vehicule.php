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
        'type',
        'immatriculation',
        'prix_jour',
        'statut',
        'carburant',
        'nbre_places',
        'localisation',
        'photo',
        'kilometrage',
        'description',
        'motif_rejet'
    ];

    public $timestamps = false;


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
}