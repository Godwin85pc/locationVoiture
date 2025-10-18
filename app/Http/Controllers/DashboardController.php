<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicule; // Assurez-vous d'importer le modèle Vehicule

class DashboardController extends Controller
{
    public function index()
    {
        $vehiculesDisponibles = Vehicule::where('statut', 'disponible')
                                       ->where('proprietaire_id', '!=', Auth::id())
                                       ->get();
        
        $mesVehicules = Vehicule::where('proprietaire_id', Auth::id())->get();
        
        $mesReservations = collect(); // À adapter selon votre modèle Reservation

        return view('dashboard', compact('vehiculesDisponibles', 'mesVehicules', 'mesReservations'));
    }
}
