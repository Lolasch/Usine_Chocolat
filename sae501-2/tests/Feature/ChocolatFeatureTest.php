<?php

namespace Tests\Feature;

use App\Models\Chocolat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChocolatFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_available_chocolats()
    {
        // Créer des chocolats
        $choc1 = Chocolat::create([
            'nom' => 'Chocolat Disponible',
            'description' => 'Prêt à être commandé',
            'disponible' => true,
        ]);

        $choc2 = Chocolat::create([
            'nom' => 'Chocolat Non Disponible',
            'description' => 'En rupture de stock',
            'disponible' => false,
        ]);

        // Vérifier que les chocolats sont créés
        $this->assertDatabaseHas('chocolats', ['nom' => 'Chocolat Disponible']);
        $this->assertDatabaseHas('chocolats', ['nom' => 'Chocolat Non Disponible']);
    }

    public function test_chocolat_can_be_toggled_availability()
    {
        $chocolat = Chocolat::create([
            'nom' => 'Chocolat à tester',
            'disponible' => true,
        ]);

        $this->assertTrue($chocolat->disponible);

        // Toggle la disponibilité
        $chocolat->update(['disponible' => false]);

        $this->assertFalse($chocolat->fresh()->disponible);
    }

    public function test_multiple_chocolats_can_be_created_and_listed()
    {
        $chocolats = [
            ['nom' => 'Test Noir', 'disponible' => true],
            ['nom' => 'Test Lait', 'disponible' => true],
            ['nom' => 'Test Blanc', 'disponible' => false],
            ['nom' => 'Test Noisette', 'disponible' => true],
        ];

        foreach ($chocolats as $data) {
            Chocolat::create($data);
        }

        // Vérifier que les chocolats de test existent
        $this->assertDatabaseHas('chocolats', ['nom' => 'Test Noir']);
        $this->assertDatabaseHas('chocolats', ['nom' => 'Test Lait']);
        $this->assertDatabaseHas('chocolats', ['nom' => 'Test Blanc']);
        $this->assertDatabaseHas('chocolats', ['nom' => 'Test Noisette']);
    }
}
