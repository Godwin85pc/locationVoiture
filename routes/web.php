<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules.index');
    
    // Routes pour les véhicules (toutes protégées par auth)
    Route::get('/vehicules/create', [VehiculeController::class, 'create'])->name('vehicules.create');
    Route::post('/vehicules', [VehiculeController::class, 'store'])->name('vehicules.store');
    Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class, 'edit'])->name('vehicules.edit');
    Route::put('/vehicules/{vehicule}', [VehiculeController::class, 'update'])->name('vehicules.update');
    Route::delete('/vehicules/{vehicule}', [VehiculeController::class, 'destroy'])->name('vehicules.destroy');
    
    // Routes pour les réservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{vehicule}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Routes Admin protégées
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [UtilisateurController::class, 'adminDashboard'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::resource('utilisateurs', UtilisateurController::class);
    
    // Gestion des réservations admin
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/validate', [ReservationController::class, 'validate'])->name('reservations.validate');
    Route::patch('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    
    // Gestion des véhicules admin
    Route::get('/vehicules', [VehiculeController::class, 'adminIndex'])->name('vehicules.index');
    Route::patch('/vehicules/{vehicule}/approve', [VehiculeController::class, 'approve'])->name('vehicules.approve');
    Route::patch('/vehicules/{vehicule}/reject', [VehiculeController::class, 'reject'])->name('vehicules.reject');
    
    // Statistiques
    Route::get('/statistiques', [UtilisateurController::class, 'statistics'])->name('statistiques');
});

require __DIR__.'/auth.php';
