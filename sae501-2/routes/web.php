<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/liste');
    }
    return redirect('/login');
})->name('home');

// Liste commandes
Route::get('/liste', [PosteController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('liste');


// AUTHENTIFICATION
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

// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'show'])->name('admin.show');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

    // Routes pour gérer les opérateurs de l'équipe
    Route::get('/admin/available-operators', [AdminController::class, 'getAvailableOperators'])->name('admin.availableOperators');
    Route::post('/admin/operators/{user}/add', [AdminController::class, 'addOperator'])->name('admin.addOperator');
    Route::post('/admin/operators/{user}/remove', [AdminController::class, 'removeOperator'])->name('admin.removeOperator');
});
