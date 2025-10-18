<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'vehicule_id',
        'client_id',
        'date_debut',
        'date_fin',
        'montant_total',
        'statut',
        'date_reservation',
        'lieu_recuperation',
        'lieu_restitution',
        'motif_rejet',
    ];

    public $timestamps = false;

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function client()
    {
        return $this->belongsTo(Utilisateur::class, 'client_id');
    }
}