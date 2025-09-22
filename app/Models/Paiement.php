<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $table = 'paiements';

    protected $fillable = [
        'reservation_id',
        'montant',
        'mode',
        'statut',
        'date_paiement',
    ];

    public $timestamps = false;

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}