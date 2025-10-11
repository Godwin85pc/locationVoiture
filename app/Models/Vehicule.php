<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Avis;

class Vehicule extends Model
{
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
        'date_ajout',
        'kilometrage',
        'packs'
    ];

    public $timestamps = false;

    public function proprietaire()
    {
        return $this->belongsTo(Utilisateur::class, 'proprietaire_id');
    }

    protected $casts = [
        'packs' => 'array',
    ];

    public function moyenneAvis()
    {
        return $this->avis()->avg('note');
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }
}
