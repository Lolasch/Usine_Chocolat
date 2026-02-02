<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\NonConformite;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class StatistiquesController extends Controller
{
    public function index()
    {
        if (!Auth::user()->isSuperviseur()) {
            abort(403);
        }

        $stocks = Stock::with('chocolat')->get();

        $totalCommandes = Commande::count();

        $commandesNonConformes = Commande::whereHas('nonConformites')->count();

        $commandesConformes = $totalCommandes - $commandesNonConformes;

        $nbNonConformes = NonConformite::count();
        
        $tauxConformite = $totalCommandes > 0
        ? round(($commandesConformes / $totalCommandes) * 100, 1)
        : 0;


        return view(
            'statistiques.index',
            compact(
                'stocks',
                'nbNonConformes',
                'commandesConformes',
                'commandesNonConformes',
                'totalCommandes',
                'tauxConformite',
            )
        );
    }
}
