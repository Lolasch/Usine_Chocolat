<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\NonConformiteController;
use App\Http\Controllers\AlerteController;

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
Route::post('/commande/{commandeId}/finaliser', [CommandeController::class, 'finaliserCommande'])->name('commande.finaliser');

// ADMIN
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/users/{user}', [AdminController::class, 'show'])->name('admin.show');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');

    // Route pour récupérer les détails d'un utilisateur en AJAX
    Route::get('/admin/users/{user}/details', [AdminController::class, 'getUserDetails'])->name('admin.userDetails');

    // Routes pour modifier le rôle et le poste via AJAX
    Route::post('/admin/users/{user}/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
    Route::post('/admin/users/{user}/change-poste', [AdminController::class, 'changePoste'])->name('admin.changePoste');
    Route::delete('/admin/users/{user}/delete-ajax', [AdminController::class, 'deleteAjax'])->name('admin.deleteAjax');

    // Routes opérateurs
    Route::get('/admin/available-operators', [AdminController::class, 'getAvailableOperators'])->name('admin.availableOperators');
    Route::post('/admin/operators/{user}/add', [AdminController::class, 'addOperator'])->name('admin.addOperator');
    Route::post('/admin/operators/{user}/remove', [AdminController::class, 'removeOperator'])->name('admin.removeOperator');

    // Routes équipes
    Route::get('/admin/equipes', [AdminController::class, 'equipes'])->name('admin.equipes');
});

// API pour récupérer les commandes par poste (refresh automatique)
Route::get('/api/commandes', function() {
    $etapes = Poste::with(['commandes' => function($query) {
        $query->with(['visiteur', 'chocolat', 'nonConformites',]);
    }])->orderBy('ordre')->get();

    return response()->json($etapes);
})->middleware('auth');

Route::post('/objectifs', [CommandeController::class, 'storeObjectif'])->name('objectifs.store');


Route::middleware('auth')->group(function () {
    Route::get('/stocks', [StockController::class, 'index'])
        ->name('stocks.index');

    Route::post('/stocks/add', [StockController::class, 'add'])
        ->name('stocks.add');

    Route::post('/stocks/add-qr', [StockController::class, 'addViaQr'])
    ->name('stocks.add.qr');

    Route::post('/stocks/update-seuil', [StockController::class, 'updateSeuil'])
    ->name('stocks.update.seuil');

});

Route::get('/statistiques', [StatistiquesController::class, 'index'])
    ->name('statistiques.index');


Route::middleware('auth')->group(function () {

    // API état panne
    Route::get('/api/alerte-active', [AlerteController::class, 'active']);

    // Superviseur
    Route::post('/alerte/panne', [AlerteController::class, 'signaler']);
    Route::post('/alerte/panne/resoudre', [AlerteController::class, 'resoudre']);
});



Route::post('/non-conformites', [NonConformiteController::class, 'store'])
    ->name('nonConformites.store');
