<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visiteur;
use App\Models\Commande;
use App\Models\Chocolat;
use App\Models\Email;
use App\Models\Poste;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    public function formulaire()
    {
        $chocolats = Chocolat::where('disponible', true)->get();
        return view('formulaire', compact('chocolats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'type_chocolat' => 'required|integer|exists:chocolats,id',
            'allergies' => 'nullable|string|max:255',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'type_chocolat.required' => 'Veuillez choisir un type de chocolat.',
        ]);

        try {
            $visiteur = Visiteur::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'nom' => strtoupper($validated['nom']),
                    'prenom' => ucfirst($validated['prenom']),
                ]
            );

            do {
                $numeroCommande = strtoupper(Str::random(7));
            } while (Commande::where('numero_commande', $numeroCommande)->exists());

            $commande = Commande::create([
                'numero_commande' => $numeroCommande,
                'visiteur_id' => $visiteur->id,
                'chocolat_id' => $validated['type_chocolat'],
                'allergie' => $validated['allergies'],
                'date_commande_debut' => now(),
                'statut' => 'en_production',
            ]);

            // Assigner la commande au premier poste
            \DB::table('commandes_postes')->insert([
                'commande_id' => $commande->id,
                'poste_id' => 1,
                'date_entree' => now(),
                'conforme' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Email::create([
                'commande_id' => $commande->id,
                'type' => 'confirmation',
                'date_envoi' => now(),
            ]);

            return redirect()->route('commande.validation', ['numero' => $numeroCommande]);

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Erreur: ' . $e->getMessage()]);
        }
    }

    public function validation($numero)
    {
        $commande = Commande::where('numero_commande', $numero)
            ->with(['visiteur', 'chocolat'])
            ->firstOrFail();

        return view('validation', compact('commande'));
    }

    public function liste()
    {
        $etapes = \App\Models\Poste::all();
        $commandesParPoste = \App\Models\Poste::with(['commandes' => function($query) {
            $query->with(['visiteur', 'chocolat']);
        }])->get();

        return view('liste', compact('etapes', 'commandesParPoste'));
    }
}
