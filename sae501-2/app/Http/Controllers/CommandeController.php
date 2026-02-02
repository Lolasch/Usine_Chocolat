<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visiteur;
use App\Models\Commande;
use App\Models\Chocolat;
use App\Models\Email;
use App\Models\Poste;
use App\Models\Objectif;
use App\Models\ConsommationsStock;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function formulaire()
    {
        $chocolats = Chocolat::with('stock')->get();

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


        $chocolat = Chocolat::with('stock')->findOrFail($validated['type_chocolat']);

        if (!$chocolat->stock || $chocolat->stock->quantite <= 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'type_chocolat' => 'Ce chocolat est en rupture de stock.'
                ]);
        }

        try {

            $visiteur = Visiteur::firstOrCreate(
                ['email' => $validated['email']],
                [
                    'nom' => strtoupper($validated['nom']),
                    'prenom' => ucfirst($validated['prenom']),
                ]
            );

            DB::transaction(function () use ($validated, $visiteur, &$commande) {

                $chocolat = Chocolat::with('stock')
                    ->lockForUpdate()
                    ->findOrFail($validated['type_chocolat']);

                $stock = $chocolat->stock;

                if (!$stock || $stock->quantite <= 0) {
                    throw new \Exception('Stock insuffisant');
                }

                do {
                    $numeroCommande = strtoupper(Str::random(7));
                } while (Commande::where('numero_commande', $numeroCommande)->exists());

                $commande = Commande::create([
                    'numero_commande' => $numeroCommande,
                    'visiteur_id' => $visiteur->id,
                    'chocolat_id' => $chocolat->id,
                    'allergie' => $validated['allergies'],
                    'date_commande_debut' => now(),
                    'statut' => 'en_production',
                ]);

                $stock->decrement('quantite', 1);

                ConsommationsStock::create([
                    'stock_id' => $stock->id,
                    'commande_id' => $commande->id,
                    'quantite_utilisee' => 1,
                    'date_consommation' => now(),
                ]);

                $premierPoste = Poste::where('actif', true)
                    ->orderBy('ordre')
                    ->first();


                DB::table('commandes_postes')->insert([
                    'commande_id' => $commande->id,
                    'poste_id' => $premierPoste->id,
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
            });

            return redirect()->route('commande.validation', ['numero' => $commande->numero_commande]);

        } catch (\Exception $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Erreur : ' . $e->getMessage()
                ]);
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
        $etapes = Poste::with(['commandes' => function ($query) {
        $query->with([
            'visiteur',
            'chocolat',
            'nonConformites', 
        ]);
    }])->orderBy('ordre')->get();

        $commandesParPoste = $etapes;

        $commandesAujourdhui = Commande::whereDate('date_commande_debut', today())->count();
        $objectif = Objectif::where('type', 'commandes')->latest()->first();
        $objectifValeur = $objectif?->valeur ?? 100;
        $pourcentage = $objectifValeur ? min(100, ($commandesAujourdhui / $objectifValeur) * 100) : 0;

        return view('liste', compact('etapes', 'commandesParPoste', 'commandesAujourdhui', 'objectifValeur', 'pourcentage'));
    }


    public function supprimerCommande($commandeId)
    {
        $commande = Commande::findOrFail($commandeId);
        $commande->delete();

        return response()->json(['success' => true, 'message' => 'Commande supprimée']);
    }

    public function prochainPoste($commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        $postActuel = DB::table('commandes_postes')
            ->where('commande_id', $commandeId)
            ->whereNull('date_sortie')
            ->first();

        if (!$postActuel) {
            return response()->json(['success' => false, 'message' => 'Poste actuel introuvable']);
        }

        // Récupérer le poste actuel pour avoir son ordre
        $posteActuelModel = Poste::find($postActuel->poste_id);

        // Chercher le prochain poste par ordre
        $prochainPoste = Poste::where('ordre', '>', $posteActuelModel->ordre)
                                ->orderBy('ordre')
                                ->first();

        if (!$prochainPoste) {
            return response()->json(['success' => false, 'message' => 'Pas de poste suivant']);
        }

        // Fermer le poste actuel
        DB::table('commandes_postes')
            ->where('id', $postActuel->id)
            ->update(['date_sortie' => now()]);

        // Créer l'entrée au prochain poste
        DB::table('commandes_postes')->insert([
            'commande_id' => $commandeId,
            'poste_id' => $prochainPoste->id,
            'date_entree' => now(),
            'conforme' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Commande passée au poste suivant']);
    }
    public function finaliserCommande($commandeId)
    {
        $commande = Commande::findOrFail($commandeId);

        $postActuel = DB::table('commandes_postes')
            ->where('commande_id', $commandeId)
            ->whereNull('date_sortie')
            ->first();

        if (!$postActuel) {
            return response()->json(['success' => false, 'message' => 'Poste actuel introuvable']);
        }

        // Fermer le dernier poste
        DB::table('commandes_postes')
            ->where('id', $postActuel->id)
            ->update(['date_sortie' => now()]);

        // Marquer la commande comme terminée et livrée
        $commande->update([
            'statut' => 'finie_livree',
            'date_commande_fin' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Commande finalisée et livrée au client !'
        ]);
    }
    public function storeObjectif(Request $request)
    {
        $validated = $request->validate([
            'objectif_commandes' => 'required|integer|min:1|max:999'
        ]);

        // Remplace l'ancien objectif du type 'commandes'
        Objectif::where('type', 'commandes')->delete();
        Objectif::create([
            'type' => 'commandes',
            'valeur' => $validated['objectif_commandes'],
            'description' => 'Objectif journalier commandes'
        ]);

        return redirect()->route('commande.liste')
            ->with('success', '🎯 Objectif mis à jour !');
    }


}
