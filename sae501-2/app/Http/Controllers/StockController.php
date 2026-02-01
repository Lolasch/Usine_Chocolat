<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\ConsommationsStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('chocolat')->get();
        return view('stocks.index', compact('stocks'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantite' => 'required|integer|min:1'
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        $stock->increment('quantite', $request->quantite);

        ConsommationsStock::create([
            'stock_id' => $stock->id,
            'quantite_utilisee' => -$request->quantite,
            'date_consommation' => now(),
        ]);

        return back()->with('success', 'Stock ajouté');
    }
    public function addViaQr(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'quantite' => 'required|integer|min:1',
            'qr_code' => 'required|string',
        ]);

        if (!str_contains($request->qr_code, 'STOCK_ID=' . $request->stock_id)) {
            return back()->withErrors([
                'error' => 'QR code invalide.'
            ]);
        }

        $stock = Stock::findOrFail($request->stock_id);

        $stock->increment('quantite', $request->quantite);

        ConsommationsStock::create([
            'stock_id' => $stock->id,
            'quantite_utilisee' => -$request->quantite,
            'date_consommation' => now(),
        ]);

        return back()->with('success', '📦 Stock ajouté via QR');
    }

    public function updateSeuil(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'seuil_min' => 'required|integer|min:0|max:999',
        ]);

        $stock = Stock::findOrFail($request->stock_id);

        $stock->update([
            'seuil_min' => $request->seuil_min,
        ]);

        return back()->with('success', '⚙️ Seuil minimum mis à jour');
    }


}
