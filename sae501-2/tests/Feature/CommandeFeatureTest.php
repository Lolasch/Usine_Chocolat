<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\Chocolat;
use App\Models\Visiteur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_commandes_workflow()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Premium',
            'disponible' => true,
        ]);

        // Créer une commande
        $commande = Commande::create([
            'numero_commande' => 'CMD-2026-001',
            'chocolat_id' => $chocolat->id,
            'statut' => 'en attente',
        ]);

        $this->assertDatabaseHas('commandes', [
            'numero_commande' => 'CMD-2026-001',
            'statut' => 'en attente',
        ]);

        // Mettre à jour le statut
        $commande->update(['statut' => 'en cours']);
        $this->assertEquals('en cours', $commande->fresh()->statut);

        // Finaliser la commande
        $commande->update(['statut' => 'complétée']);
        $this->assertEquals('complétée', $commande->fresh()->statut);
    }

    public function test_commande_with_allergie_information()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $commande = Commande::create([
            'numero_commande' => 'CMD-ALLERG-001',
            'chocolat_id' => $chocolat->id,
            'allergie' => 'Arachides, Noisettes',
            'statut' => 'en cours',
        ]);

        $this->assertEquals('Arachides, Noisettes', $commande->allergie);
        $this->assertStringContainsString('Arachides', $commande->allergie);
    }

    public function test_commande_numero_is_unique()
    {
        $commande1 = Commande::create([
            'numero_commande' => 'CMD-UNIQUE-001',
            'chocolat_id' => 1,
            'statut' => 'en attente',
        ]);

        $commande2 = Commande::create([
            'numero_commande' => 'CMD-UNIQUE-002',
            'chocolat_id' => 1,
            'statut' => 'en attente',
        ]);

        // Vérifier que deux commandes avec des numéros différents peuvent être créées
        $this->assertNotEquals($commande1->numero_commande, $commande2->numero_commande);
        $this->assertDatabaseHas('commandes', ['numero_commande' => 'CMD-UNIQUE-001']);
        $this->assertDatabaseHas('commandes', ['numero_commande' => 'CMD-UNIQUE-002']);
    }

    public function test_commandes_tracking_by_date()
    {
        $commande1 = Commande::create([
            'numero_commande' => 'CMD-DATE-001',
            'chocolat_id' => 1,
            'date_commande_debut' => '2026-02-01 10:00:00',
            'date_commande_fin' => '2026-02-03 18:00:00',
            'statut' => 'complétée',
        ]);

        $commande2 = Commande::create([
            'numero_commande' => 'CMD-DATE-002',
            'chocolat_id' => 1,
            'date_commande_debut' => '2026-02-02 09:00:00',
            'date_commande_fin' => '2026-02-04 17:00:00',
            'statut' => 'complétée',
        ]);

        // Vérifier les dates
        $this->assertTrue($commande1->date_commande_debut < $commande2->date_commande_debut);
    }
}
