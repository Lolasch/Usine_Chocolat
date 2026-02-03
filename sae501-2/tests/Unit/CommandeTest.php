<?php

namespace Tests\Unit;

use App\Models\Commande;
use App\Models\Chocolat;
use App\Models\Visiteur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeTest extends TestCase
{
    use RefreshDatabase;

    public function test_commande_can_be_created()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $commande = Commande::create([
            'numero_commande' => 'CMD-001',
            'chocolat_id' => $chocolat->id,
            'statut' => 'en cours',
        ]);

        $this->assertDatabaseHas('commandes', [
            'numero_commande' => 'CMD-001',
            'statut' => 'en cours',
        ]);
    }

    public function test_commande_date_attributes_are_cast_to_datetime()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $commande = Commande::create([
            'numero_commande' => 'CMD-002',
            'chocolat_id' => $chocolat->id,
            'statut' => 'complétée',
            'date_commande_debut' => '2026-02-01 10:00:00',
            'date_commande_fin' => '2026-02-03 18:00:00',
        ]);

        $this->assertInstanceOf(\Carbon\Carbon::class, $commande->date_commande_debut);
        $this->assertInstanceOf(\Carbon\Carbon::class, $commande->date_commande_fin);
    }

    public function test_commande_fillable_attributes()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $commande = Commande::create([
            'numero_commande' => 'CMD-003',
            'chocolat_id' => $chocolat->id,
            'allergie' => 'Arachides',
            'statut' => 'en attente',
        ]);

        $this->assertEquals('CMD-003', $commande->numero_commande);
        $this->assertEquals('Arachides', $commande->allergie);
        $this->assertEquals('en attente', $commande->statut);
    }

    public function test_commande_statut_values()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $statutValues = ['en cours', 'complétée', 'en attente', 'annulée'];

        foreach ($statutValues as $statut) {
            $commande = Commande::create([
                'numero_commande' => 'CMD-' . uniqid(),
                'chocolat_id' => $chocolat->id,
                'statut' => $statut,
            ]);

            $this->assertEquals($statut, $commande->statut);
        }
    }
}
