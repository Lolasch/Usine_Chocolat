<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NonConformite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonConformiteController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperviseur()) {
            return response()->json(['message' => 'Interdit'], 403);
        }

        $validated = $request->validate([
            'commande_id' => 'required|exists:commandes,id',
            'poste_id' => 'nullable|exists:postes,id',
            'description' => 'required|string|max:255',
        ]);

        NonConformite::create([
            'commande_id'   => $validated['commande_id'],
            'poste_id'      => $validated['poste_id'] ?? null,
            'description'   => $validated['description'],
            'date_detection'=> now(),
        ]);

        return response()->json(['success' => true]);
    }
}
