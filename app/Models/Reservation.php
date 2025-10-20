<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = true; // utiliser created_at / updated_at

    protected $fillable = [
        'vehicule_id',
        'client_id',
        'date_debut',
        'date_fin',
        'montant_total',
        'pack',
        'nom',
        'prenom',
        'email',
        'telephone',
        'statut',
        'lieu_recuperation',
        'lieu_restitution',
        'motif_rejet',
    ];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }
}