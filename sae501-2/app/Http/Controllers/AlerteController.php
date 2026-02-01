<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alerte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlerteController extends Controller
{
    // Récupérer l'alerte active
    public function active()
    {
        $alerte = Alerte::where('type', 'panne')
            ->where('resolue', false)
            ->latest()
            ->first();

        return response()->json([
            'active' => $alerte !== null,
            'alerte' => $alerte
        ]);
    }


    // Signaler une panne (SUPERVISEUR UNIQUEMENT)
    public function signaler(Request $request)
    {
        if (Auth::user()->role->nom !== 'superviseur') {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:255'
        ]);

        Alerte::create([
            'type' => 'panne',
            'message' => $request->message,
            'date_alerte' => now(),
            'resolue' => false
        ]);

        return response()->json(['success' => true]);
    }

    // Lever la panne (SUPERVISEUR)
    public function resoudre()
    {
        Alerte::where('type', 'panne')
            ->where('resolue', false)
            ->update(['resolue' => true]);

        return response()->json(['success' => true]);
    }

}
