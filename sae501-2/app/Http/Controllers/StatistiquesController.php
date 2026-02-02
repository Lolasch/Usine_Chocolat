<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Poste;
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

        // Nombre total de chocolats
        $totalStocks = Stock::count();

        $score = Stock::selectRaw("
            SUM(
                CASE
                    WHEN quantite <= 0 THEN 1
                    WHEN quantite <= seuil_min THEN 0.5
                    ELSE 0
                END
            ) as score
        ")->value('score');

        $tauxRotationStocks = $totalStocks > 0
            ? round(($score / $totalStocks) * 100, 1)
            : 0;

        $posteLivraisonId = Poste::where('nom', 'Livraison')->value('id');

        $commandesLivrees = Commande::whereHas('commandesPostes', function ($q) use ($posteLivraisonId) {
            $q->where('poste_id', $posteLivraisonId)
            ->whereNotNull('date_sortie');
        })->count();

        $tauxLivraison = $totalCommandes > 0
            ? round(($commandesLivrees / $totalCommandes) * 100, 1)
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
                'tauxRotationStocks',
                'tauxLivraison',
                'commandesLivrees',

            )
        );
    }
}
