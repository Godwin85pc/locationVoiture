<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;
use App\Models\OffreVehicule;
use App\Http\Controllers\OffreVehiculeController;

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules.index');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{vehicule}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    
    // ROUTES VEHICULES
    Route::get('/vehicules/create', function () {
        return view('01-ajout_voiture'); // Utilisez directement votre vue existante
    })->name('vehicules.create');
    
    Route::post('/vehicules', [VehiculeController::class, 'store'])->name('vehicules.store');
    Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class, 'edit'])->name('vehicules.edit');
    Route::put('/vehicules/{vehicule}', [VehiculeController::class, 'update'])->name('vehicules.update');
    Route::delete('/vehicules/{vehicule}', [VehiculeController::class, 'destroy'])->name('vehicules.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('dashboard'); // Tous les autres vont au dashboard
    }
})->middleware('auth');

Route::get('/admin', [UtilisateurController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('auth');

require __DIR__.'/auth.php';


Route::get('/dashboard/offres-disponibles', [OffreVehiculeController::class, 'fetch'])->name('offres.disponibles');


