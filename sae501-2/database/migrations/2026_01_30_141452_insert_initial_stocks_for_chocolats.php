<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('stocks')->insert([
            [
                'nom' => 'Chocolat noir',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat noir aux amandes',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat noir aux noisettes',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat au lait',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat lait aux amandes',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat lait aux noisettes',
                'type' => 'chocolat',
                'quantite' => 0,
                'seuil_min' => 5,
                'actif' => true,
                'chocolat_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
