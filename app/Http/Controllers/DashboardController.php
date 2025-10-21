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

    /**
     * Admin preview of user dashboard without switching guards.
     */
    public function adminPreview()
    {
        // Utiliser l'admin connecté (guard admin) pour un aperçu
        $admin = Auth::guard('admin')->user();
        // Données du dashboard utilisateur sans dépendre d'un user web
        $vehiculesDisponibles = Vehicule::where('disponible', true)->get();
        $mesVehicules = method_exists($admin, 'vehicules') ? $admin->vehicules : collect();
        $mesReservations = method_exists($admin, 'reservations') ? $admin->reservations : collect();

        // Indiquer au template que c'est un mode aperçu
        return view('dashboard', [
            'vehiculesDisponibles' => $vehiculesDisponibles,
            'mesVehicules' => $mesVehicules,
            'mesReservations' => $mesReservations,
            'isAdminPreview' => true,
        ]);
    }
}
