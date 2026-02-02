<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Objectif;


class ObjectifController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperviseur()) {
            abort(403);
        }

        $validated = $request->validate([
            'valeur' => 'required|integer|min:1'
        ]);

        // Remplace l'ancien objectif "commandes"
        Objectif::where('type', 'commandes')->delete();

        Objectif::create([
            'type' => 'commandes',
            'valeur' => $validated['valeur']
        ]);

        return back()->with('success', 'Objectif mis à jour !');
    }

}
