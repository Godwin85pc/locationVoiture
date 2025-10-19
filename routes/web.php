<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CommisionController;

// Côté loueur

// Côté admin
Route::get('/admin/notification', [AdminController::class, 'notificationVehicule'])->name('admin.notification');
Route::post('/admin/vehicule/valider/{id}', [AdminController::class, 'validerVehicule'])->name('admin.valider_vehicule');

// Utilisateurs
Route::resource('utilisateurs', UtilisateurController::class);

// Véhicules
Route::resource('vehicules', VehiculeController::class);

// Réservations
Route::resource('reservations', ReservationController::class);

// Paiements
Route::resource('paiements', PaiementController::class);

// Commissions
Route::resource('commissions', CommisionController::class);
// Page de calcul du prix après formulaire
Route::post('/vehicules/prix', [VehiculeController::class, 'calculPrix'])->name('vehicules.prix');

Route::put('/vehicules/{id}', [VehiculeController::class, 'update'])->name('vehicules.update');

// Page d'accueiluse App\Models\OffreVehicule;
use App\Http\Controllers\OffreVehiculeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OffreAgenceController;

Route::get('/', function () {
    return view('index');
    })->name('index');

// Route::post('01-ajout_voiture', function (Illuminate\Http\Request $request) {
//     // Tu peux ici stocker les infos du véhicule dans la session
//     // avant d'afficher la page suivante
//     session(['vehicule' => $request->all()]);
//     return view('01-ajout_voiture');
// });
Route::get('/02-options_extras', function () {
    return view('02-options_extras');
})->name('02-options_extras');
Route::get('/confirmation', function () {
    return view('confirmation');
})->name('confirmation');
Route::get('/03-maintenance', function () {
    return view('03-maintenance');
})->name('03-maintenance');
// Route pour la page prix
Route::get('/prix', function () {
    return view('prix'); // nom du fichier Blade sans l'extension
})->name('prix'); // nom de route utilisé dans Blade

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

Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('dashboard'); // Tous les autres vont au dashboard
    }
})->middleware('auth');

Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth', 'admin']);

// Routes pour la gestion des offres d'agence
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('offres', OffreAgenceController::class);
    Route::patch('offres/{offre}/toggle-status', [OffreAgenceController::class, 'toggleStatus'])->name('offres.toggle-status');
});
Route::get('/resume', [VehiculeController::class, 'resume'])->name('resume');
Route::get('/vehicule/resume', [VehiculeController::class, 'resume'])->name('prix');
require __DIR__.'/auth.php';

Route::get('/dashboard/offres-disponibles', [OffreVehiculeController::class, 'fetch'])->name('offres.disponibles');
