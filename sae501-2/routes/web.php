<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosteController;
use Illuminate\Support\Facades\Route;
use App\Models\Poste;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('commande.liste');
    }
    return redirect('/login');
})->name('home');

// Liste commandes
Route::get('/liste', [CommandeController::class, 'liste'])
    ->middleware('auth')->name('commande.liste');

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
Route::post('/commande/{commandeId}/supprimer', [CommandeController::class, 'supprimerCommande'])->name('commande.supprimer');
Route::post('/commande/{commandeId}/prochainPoste', [CommandeController::class, 'prochainPoste'])->name('commande.prochainPoste');


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

// API pour récupérer les commandes par poste (refresh automatique)
Route::get('/api/commandes', function() {
    $etapes = Poste::with(['commandes' => function($query) {
        $query->with(['visiteur', 'chocolat']);
    }])->orderBy('ordre')->get();

    return response()->json($etapes);
})->middleware('auth');
