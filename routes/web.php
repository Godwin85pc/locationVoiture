<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Page de connexion
Route::get('/connection', function () {
    return view('connection'); // resources/views/connection.blade.php
})->name('connection');

// Page de connexion
Route::get('/01-ajout_voiture', function () {
    return view('01-ajout_voiture'); // resources/views/connection.blade.php
})->name('01-ajout_voiture');

Route::get('/02-options_extras', function () {
    return view('02-options_extras'); // resources/views/connection.blade.php
})->name('02-options_extras');

Route::get('/03-maintenance', function () {
    return view('03-maintenance'); // resources/views/connection.blade.php
})->name('03-maintenance');

Route::get('/04-pricing_info', function () {
    return view('04-pricing_info'); // resources/views/connection.blade.php
})->name('04-pricing_info');

Route::get('/05-set_prices', function () {
    return view('05-set_prices'); // resources/views/connection.blade.php
})->name('05-set_prices');

Route::get('/inscrit', function () {
    return view('inscrit'); // resources/views/connection.blade.php
})->name('inscrit');

Route::get('/summary', function () {
    return view('summary'); // resources/views/connection.blade.php
})->name('summary');
