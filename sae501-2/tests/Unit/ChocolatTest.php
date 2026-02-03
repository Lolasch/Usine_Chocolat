<?php

namespace Tests\Unit;

use App\Models\Chocolat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChocolatTest extends TestCase
{
    use RefreshDatabase;

    public function test_chocolat_can_be_created()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Noir 70%',
            'description' => 'Chocolat haut de gamme',
            'disponible' => true,
        ]);

        $this->assertDatabaseHas('chocolats', [
            'nom' => 'Chocolat Noir 70%',
            'disponible' => true,
        ]);
    }

    public function test_chocolat_has_fillable_attributes()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat au Lait',
            'image' => 'chocolat-lait.jpg',
            'description' => 'Doux et savoureux',
            'disponible' => false,
        ]);

        $this->assertEquals('Chocolat au Lait', $chocolat->nom);
        $this->assertEquals('chocolat-lait.jpg', $chocolat->image);
        $this->assertFalse($chocolat->disponible);
    }

    public function test_chocolat_disponible_is_casted_to_boolean()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Test Chocolat',
            'disponible' => 1,
        ]);

        $this->assertTrue($chocolat->disponible);
        $this->assertIsBool($chocolat->disponible);
    }

    public function test_chocolat_can_have_commandes()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat Premium',
            'disponible' => true,
        ]);

        $this->assertEmpty($chocolat->commandes);
    }

    public function test_chocolat_cannot_be_created_without_nom()
    {
        // Vérifier que certains champs sont requis
        $this->expectException(\Illuminate\Database\QueryException::class);

        Chocolat::create([
            'description' => 'Pas de nom',
        ]);
    }
}
