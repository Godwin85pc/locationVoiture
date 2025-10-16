<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffreVehicule extends Model
{
    protected $table = 'offre_vehicules';

    protected $fillable = [
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
    ];

    protected $casts = [
        'climatisation' => 'boolean',
        'packs' => 'array',
        'options' => 'array',
        'note' => 'float',
        'portes' => 'integer',
        'places' => 'integer',
        'kilometrage' => 'integer',
    ];
}
