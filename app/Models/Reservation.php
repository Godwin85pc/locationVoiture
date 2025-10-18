<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false; // on n’utilise pas created_at / updated_at

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
