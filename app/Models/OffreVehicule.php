<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffreVehicule extends Model
{
    protected $table = 'offre_vehicules';

    protected $fillable = [
        // Champs existants
        'nom',
        'categorie',
        'etat',
        'note',
        'transmission',
        'climatisation',
        'portes',
        'places',
        'carburant',
        'kilometrage',
        'image',
        'packs',
        'options',
        // Nouveaux champs pour les offres d'agence
        'vehicule_id',
        'prix_par_jour',
        'description_offre',
        'date_debut_offre',
        'date_fin_offre',
        'reduction_pourcentage',
        'conditions_speciales',
        'statut',
        'created_by'
    ];

    protected $casts = [
        'climatisation' => 'boolean',
        'packs' => 'array',
        'options' => 'array',
        'note' => 'float',
        'portes' => 'integer',
        'places' => 'integer',
        'kilometrage' => 'integer',
        'prix_par_jour' => 'decimal:2',
        'reduction_pourcentage' => 'decimal:2',
        'date_debut_offre' => 'date',
        'date_fin_offre' => 'date',
    ];

    /**
     * Relation avec le véhicule
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Relation avec l'utilisateur qui a créé l'offre
     */
    public function createdBy()
    {
        return $this->belongsTo(Utilisateur::class, 'created_by');
    }

    /**
     * Vérifier si l'offre est active
     */
    public function isActive()
    {
        return $this->statut === 'active' && 
               $this->date_debut_offre <= now() && 
               $this->date_fin_offre >= now();
    }

    /**
     * Vérifier si l'offre est expirée
     */
    public function isExpired()
    {
        return $this->date_fin_offre < now();
    }

    /**
     * Calculer le prix après réduction
     */
    public function getPrixAvecReductionAttribute()
    {
        if ($this->reduction_pourcentage > 0) {
            return $this->prix_par_jour * (1 - $this->reduction_pourcentage / 100);
        }
        return $this->prix_par_jour;
    }

    /**
     * Scope pour les offres actives
     */
    public function scopeActive($query)
    {
        return $query->where('statut', 'active')
                    ->where('date_debut_offre', '<=', now())
                    ->where('date_fin_offre', '>=', now());
    }

    /**
     * Scope pour les offres d'agence avec véhicule
     */
    public function scopeOffreAgence($query)
    {
        return $query->whereNotNull('vehicule_id');
    }
}
