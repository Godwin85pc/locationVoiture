<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UtilisateurController;

Route::get('/', function () {
    return view('index');
})->name('index');

// Page de visualisation des voitures
Route::get('voiture2', function () {
    return view('voiture2'); // resources/views/connection.blade.php
})->name('voiture2');

// Page de connexion
Route::get('/reservation', function () {
    return view('reservation'); // resources/views/connection.blade.php
})->name('reservation');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/redirect-after-login', function () {
    $user = Auth::user();
    if ($user->role === 'particulier') {
        return redirect()->route('ajout_voitures');
    } elseif ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('dashboard');
    }
})->middleware('auth');

Route::get('/01-ajout_voitures', function () {
    return view('01-ajout_voitures');
})->name('ajout_voitures')->middleware('auth');

Route::get('/admin', [UtilisateurController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('auth');

require __DIR__.'/auth.php';
