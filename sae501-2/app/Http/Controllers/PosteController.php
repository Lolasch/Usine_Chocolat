<?php

namespace App\Http\Controllers;

use App\Models\Poste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosteController extends Controller
{
    /**
     * Affiche la liste des postes (étapes)
     */
    public function index()
    {
        $etapes = Poste::where('actif', true)
            ->orderBy('ordre')
            ->get();

        return view('liste', compact('etapes'));
    }
}
