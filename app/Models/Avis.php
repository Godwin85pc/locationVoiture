<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis_vehicules'; // ta table
    protected $fillable = ['vehicule_id', 'nom_utilisateur', 'note', 'commentaire'];

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}
