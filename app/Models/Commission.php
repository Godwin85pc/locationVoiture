<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table = 'commissions';

    protected $fillable = [
        'vehicule_id',
        'pourcentage',
        'montant_particulier',
        'montant_agence',
        'date_calcule',
    ];

    public $timestamps = false;

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }
}