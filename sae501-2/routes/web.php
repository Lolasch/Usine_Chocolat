<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('connexion');
})->name('home');

// AUTHENTIFICATION
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



// VISITEURS
Route::get('/accueil', function () {
    return view('accueil');
})->name('accueil');

// Routes pour les commandes de chocolat
Route::get('/formulaire', [CommandeController::class, 'formulaire'])->name('commande.formulaire');
Route::post('/commandes', [CommandeController::class, 'store'])->name('commande.store');
Route::get('/commande/{numero}/validation', [CommandeController::class, 'validation'])->name('commande.validation');
