<?php

namespace Tests\Unit;

use App\Models\Stock;
use App\Models\Chocolat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    public function test_stock_can_be_created()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Test',
            'disponible' => true,
        ]);

        $stock = Stock::create([
            'chocolat_id' => $chocolat->id,
            'quantite' => 100,
            'seuil_min' => 10,
        ]);

        $this->assertDatabaseHas('stocks', [
            'chocolat_id' => $chocolat->id,
            'quantite' => 100,
        ]);
    }

    public function test_stock_quantite_can_be_updated()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Premium',
            'disponible' => true,
        ]);

        $stock = Stock::create([
            'chocolat_id' => $chocolat->id,
            'quantite' => 50,
            'seuil_min' => 5,
        ]);

        $stock->update(['quantite' => 75]);

        $this->assertEquals(75, $stock->fresh()->quantite);
    }

    public function test_stock_alert_when_quantite_below_minimum()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Alert',
            'disponible' => true,
        ]);

        $stock = Stock::create([
            'chocolat_id' => $chocolat->id,
            'quantite' => 3,
            'seuil_min' => 10,
        ]);

        // Vérifier que la quantité est en dessous du minimum
        $this->assertLessThan($stock->seuil_min, $stock->quantite);
    }
}
