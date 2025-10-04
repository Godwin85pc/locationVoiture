<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicule; // Assurez-vous d'importer le modèle Vehicule

class DashboardController extends Controller
{
    public function index()
    {
        $vehiculesDisponibles = Vehicule::where('disponible', true)->get();
        $mesVehicules = Auth::user()->vehicules; // relation à définir
        $mesReservations = Auth::user()->reservations; // relation à définir
        // $mesReservations = auth()->user()->reservations; // relation à définir

        return view('dashboard', compact('vehiculesDisponibles', 'mesVehicules', 'mesReservations'));
    }
}
