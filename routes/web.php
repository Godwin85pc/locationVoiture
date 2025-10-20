<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// Contraintes globales des paramètres
Route::pattern('vehicule', '[0-9]+');
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehiculeController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CommisionController;
use App\Models\OffreVehicule;
use App\Http\Controllers\OffreVehiculeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OffreAgenceController;

// -------------------------
// Pages publiques / statiques
// -------------------------
Route::get('/', fn() => view('index'))->name('index');
// Alias de compatibilité: redirige vers la page de connexion Laravel
Route::get('/connection', function () {
    return redirect()->route('login');
})->name('connection');
Route::get('/01-ajout_voiture', fn() => view('01-ajout_voiture'))->name('01-ajout_voiture');
Route::get('/louable', fn() => view('louable'))->name('louable');
Route::get('/02-options_extras', fn() => view('02-options_extras'))->name('02-options_extras');
Route::get('/03-maintenance', fn() => view('03-maintenance'))->name('03-maintenance');
Route::get('/04-pricing_info', fn() => view('04-pricing_info'))->name('04-pricing_info');
Route::get('/05-set_prices', fn() => view('05-set_prices'))->name('05-set_prices');
Route::get('/prix', fn() => view('prix'))->name('prix');
Route::get('/confirmation', fn() => view('confirmation'))->name('confirmation');
Route::get('/inscrit', fn() => view('inscrit'))->name('inscrit');
Route::get('/summary', fn() => view('summary'))->name('summary');
Route::get('/reservation', fn() => view('reservation'))->name('reservation');

// -------------------------
// Routes véhicules / avis publiques
// -------------------------
Route::get('/voiture2', [VehiculeController::class, 'rechercher'])->name('voiture2');
// Important: contraindre l'ID pour éviter de capturer /vehicules/create
Route::get('/vehicules/{vehicule}', [VehiculeController::class, 'show'])
    ->whereNumber('vehicule')
    ->name('vehicules.show');
Route::post('/vehicules/{vehicule}/avis', [VehiculeController::class, 'storeAvis'])
    ->whereNumber('vehicule')
    ->name('vehicules.storeAvis');
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');

// -------------------------
// Routes pour calcul de prix
// -------------------------
Route::post('/vehicules/prix', [VehiculeController::class, 'calculPrix'])->name('vehicules.prix');
//ne tantepas d'effacer la route ci dako 
Route::post('/vehicules', [VehiculeController::class, 'store'])->name('vehicules.store');

// -------------------------
// ROUTE DE DEBUG TEMPORAIRE
// -------------------------
Route::get('/debug-vehicules-create', function() {
    return 'DEBUG: Route accessible. User: ' . (Auth::check() ? Auth::user()->name : 'Non connecté');
});

Route::get('/debug-vehicule-controller', [VehiculeController::class, 'create']);

// Test route resource sans middleware
Route::get('/test-vehicules-create', [VehiculeController::class, 'create']);

// Test route resource AVEC middleware
Route::middleware(['auth'])->get('/test-vehicules-create-auth', [VehiculeController::class, 'create']);

// ROUTE TEMPORAIRE POUR FORCER L'ACCÈS
Route::get('/force-vehicules-create', function() {
    try {
        $controller = new \App\Http\Controllers\VehiculeController();
        return $controller->create();
    } catch (\Exception $e) {
        return 'ERREUR: ' . $e->getMessage() . ' | FILE: ' . $e->getFile() . ' | LINE: ' . $e->getLine();
    }
});

// ROUTE POUR CONNEXION AUTO + TEST
Route::get('/login-and-test', function() {
    // Connexion automatique avec l'utilisateur test
    $user = \App\Models\Utilisateur::where('email', 'test@test.com')->first();
    if ($user) {
        Auth::login($user);
        return redirect('/vehicules/create');
    }
    return 'Utilisateur test non trouvé';
});

// -------------------------
// Routes authentifiées
// -------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour le processus de création de véhicule en plusieurs étapes
    Route::post('/02-options_extras', [VehiculeController::class, 'storeStep1'])->name('vehicules.step1');
    Route::post('/03-maintenance', [VehiculeController::class, 'storeStep2'])->name('vehicules.step2');
    Route::post('/04-pricing_info', [VehiculeController::class, 'storeStep3'])->name('vehicules.step3');
    Route::post('/05-set_prices', [VehiculeController::class, 'storeStep4'])->name('vehicules.step4');
    Route::post('/confirmation', [VehiculeController::class, 'storeStep5'])->name('vehicules.step5');
    
    // Route pour offres disponibles
    Route::get('/dashboard/offres-disponibles', [VehiculeController::class, 'offresDisponibles'])->name('offres.disponibles');
});

// VEHICULES ROUTES SÉPARÉES POUR DEBUG
Route::middleware(['auth'])->group(function () {
    // Véhicules (utilisateur) - Resource routes automatiques
    Route::resource('vehicules', VehiculeController::class);
    Route::post('/vehicules/recherche', [VehiculeController::class, 'rechercher'])->name('vehicules.recherche');
    
    // Réservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create/{vehicule}', [ReservationController::class, 'create'])->name('reservations.create');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('reservation.create');
    
    // Recapitulatif de recherche
    Route::post('/recapitulatif', [VehiculeController::class, 'rechercher'])->name('recapitulatif');
    Route::get('/recapitulatif', [VehiculeController::class, 'rechercher'])->name('recapitulatif');
    
    // Routes pour les ressources complètes
    Route::resource('utilisateurs', UtilisateurController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('commissions', CommisionController::class);
});

// -------------------------
// Profile utilisateur
// -------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// -------------------------
// Redirection après login
// -------------------------
Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('dashboard');
    }
})->middleware('auth');

// -------------------------
// Routes Admin
// -------------------------
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware(['auth:admin', 'admin']);

Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Notifications et validation véhicules
    Route::get('/notification', [AdminController::class, 'notificationVehicule'])->name('notification');
    Route::post('/vehicule/valider/{id}', [AdminController::class, 'validerVehicule'])->name('valider_vehicule');
    
    // Offres d'agence
    Route::resource('offres', OffreAgenceController::class);
    Route::patch('offres/{offre}/toggle-status', [OffreAgenceController::class, 'toggleStatus'])->name('offres.toggle-status');
    
    // Réservations (admin)
    Route::get('/reservations', [ReservationController::class, 'adminIndex'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/validate', [ReservationController::class, 'validateReservation'])->name('reservations.validate');
    Route::patch('/reservations/{reservation}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');
    
    // Utilisateurs (admin)
    Route::get('/utilisateurs', [UtilisateurController::class, 'adminIndex'])->name('utilisateurs.index');
    Route::patch('/utilisateurs/{utilisateur}/toggle-status', [UtilisateurController::class, 'toggleStatus'])->name('utilisateurs.toggle-status');
    
    // Véhicules (admin)
    Route::get('/vehicules', [VehiculeController::class, 'adminIndex'])->name('vehicules.index');
    Route::patch('/vehicules/{vehicule}/approve', [VehiculeController::class, 'approve'])->name('vehicules.approve');
    Route::patch('/vehicules/{vehicule}/reject', [VehiculeController::class, 'reject'])->name('vehicules.reject');
    Route::patch('/vehicules/{vehicule}/resume', [VehiculeController::class, 'resume'])->name('vehicules.resume');
    
    // Notifications admin
    Route::get('/notifications/vehicules', [AdminController::class, 'notificationVehicule'])->name('notifications.vehicules');
});

// Routes d'authentification
require __DIR__.'/auth.php';
