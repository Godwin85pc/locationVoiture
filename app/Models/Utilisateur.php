<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Utilisateur extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'telephone',
        'role',
        'date_creation',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Retourne le mot de passe pour l'authentification.
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Indique à Laravel le nom du champ mot de passe personnalisé.
     */
    public function getAuthPasswordName()
    {
        return 'mot_de_passe';
    }
}
