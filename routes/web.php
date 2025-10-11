<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\VehiculeController; // ✅ Import ajouté ici

//  Page d'accueil
Route::get('/', function () {
    return view('index');
})->name('index');

//  Pages statiques
Route::get('/connection', fn() => view('connection'))->name('connection');
Route::get('/01-ajout_voiture', fn() => view('01-ajout_voiture'))->name('01-ajout_voiture');
Route::get('/02-options_extras', fn() => view('02-options_extras'))->name('02-options_extras');
Route::get('/03-maintenance', fn() => view('03-maintenance'))->name('03-maintenance');
Route::get('/04-pricing_info', fn() => view('04-pricing_info'))->name('04-pricing_info');
Route::get('/05-set_prices', fn() => view('05-set_prices'))->name('05-set_prices');
Route::get('/inscrit', fn() => view('inscrit'))->name('inscrit');
Route::get('/summary', fn() => view('summary'))->name('summary');
Route::get('/reservation', fn() => view('reservation'))->name('reservation');

//  Page de visualisation des voitures (depuis le contrôleur)
Route::get('/voiture2', [VehiculeController::class, 'index'])->name('voiture2');
Route::get('/vehicules/{id}', [VehiculeController::class, 'show'])->name('vehicules.show');
Route::post('/vehicules/{id}/avis', [VehiculeController::class, 'storeAvis'])->name('vehicules.storeAvis');
Route::post('/avis', [AvisController::class, 'store'])->name('avis.store');


//  Tableau de bord
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//  Gestion du profil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//  Redirection après connexion
Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user->role === 'particulier') {
        return redirect()->route('ajout_voitures');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('dashboard');
})->middleware('auth');

//  Page ajout voiture
Route::get('/01-ajout_voitures', fn() => view('01-ajout_voitures'))
    ->name('ajout_voitures')
    ->middleware('auth');

//  Tableau de bord admin
Route::get('/admin', [UtilisateurController::class, 'adminDashboard'])
    ->name('admin.dashboard')
    ->middleware('auth');

require __DIR__.'/auth.php';

//redirectionn apres recherche  
Route::post('/voiture2',[VehiculeController::class,'recuperer'] )->name('recapitulatif');
Route::get('/voiture2',[VehiculeController::class,'recuperer'] )->name('recapitulatif');



