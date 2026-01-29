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

            // Récupérer le premier poste actif (ordre le plus petit)
            $premierPoste = Poste::where('actif', true)
                ->orderBy('ordre')
                ->first();

            if (!$premierPoste) {
                throw new \Exception('Aucun poste actif trouvé');
            }

            \DB::table('commandes_postes')->insert([
                'commande_id' => $commande->id,
                'poste_id' => $premierPoste->id, // ✅ ID réel du poste
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
        $etapes = Poste::with(['commandes' => function($query) {
            $query->with(['visiteur', 'chocolat']);
        }])->orderBy('ordre')->get();

        $commandesParPoste = $etapes;

        return view('liste', compact('etapes', 'commandesParPoste'));
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

}
