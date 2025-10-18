<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvisController; // si tu utilises ce controller

// -------------------------
// Pages publiques / statiques
// -------------------------
Route::get('/', fn() => view('index'))->name('index');
Route::get('/connection', fn() => view('connection'))->name('connection');
Route::get('/01-ajout_voiture', fn() => view('01-ajout_voiture'))->name('01-ajout_voiture');
Route::get('/02-options_extras', fn() => view('02-options_extras'))->name('02-options_extras');
Route::get('/03-maintenance', fn() => view('03-maintenance'))->name('03-maintenance');
Route::get('/04-pricing_info', fn() => view('04-pricing_info'))->name('04-pricing_info');
Route::get('/05-set_prices', fn() => view('05-set_prices'))->name('05-set_prices');
Route::get('/inscrit', fn() => view('inscrit'))->name('inscrit');
Route::get('/summary', fn() => view('summary'))->name('summary');
Route::get('/reservation', fn() => view('reservation'))->name('reservation');

// -------------------------
// Routes véhicules / avis publiques
// -------------------------
Route::get('/voiture2', [VehiculeController::class, 'index'])->name('voiture2');
Route::get('/vehicules/{id}', [VehiculeController::class, 'show'])->name('vehicules.show');
Route::post('/vehicules/{id}/avis', [VehiculeController::class, 'storeAvis'])->name('vehicules.storeAvis');
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');

// -------------------------
// Routes protégées utilisateur
// -------------------------

//j'ai retire le verified ici 'verified'
Route::middleware(['auth'])->group(function () {

    // Dashboard utilisateur
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Véhicules utilisateur (CRUD complet)
    Route::get('/vehicules', [VehiculeController::class, 'index'])->name('vehicules.index');
    Route::get('/vehicules/create', [VehiculeController::class, 'create'])->name('vehicules.create');
    Route::post('/vehicules', [VehiculeController::class, 'store'])->name('vehicules.store');
    Route::get('/vehicules/{vehicule}/edit', [VehiculeController::class, 'edit'])->name('vehicules.edit');
    Route::put('/vehicules/{vehicule}', [VehiculeController::class, 'update'])->name('vehicules.update');
    Route::delete('/vehicules/{vehicule}', [VehiculeController::class, 'destroy'])->name('vehicules.destroy');

    // Réservations utilisateur
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirection après recherche
    Route::post('/voiture2', [VehiculeController::class, 'recuperer'])->name('recapitulatif');
    Route::get('/voiture2', [VehiculeController::class, 'recuperer'])->name('recapitulatif');
});

// -------------------------
// Routes Admin
// -------------------------
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [UtilisateurController::class, 'adminDashboard'])->name('dashboard');

    // Gestion des utilisateurs
    Route::resource('utilisateurs', UtilisateurController::class);

    // Réservations admin
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/validate', [ReservationController::class, 'validate'])->name('reservations.validate');
    Route::patch('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');

    // Véhicules admin
    Route::get('/vehicules', [VehiculeController::class, 'adminIndex'])->name('vehicules.index');
    Route::patch('/vehicules/{vehicule}/approve', [VehiculeController::class, 'approve'])->name('vehicules.approve');
    Route::patch('/vehicules/{vehicule}/reject', [VehiculeController::class, 'reject'])->name('vehicules.reject');

    // Statistiques
    Route::get('/statistiques', [UtilisateurController::class, 'statistics'])->name('statistiques');
});

require __DIR__.'/auth.php';
