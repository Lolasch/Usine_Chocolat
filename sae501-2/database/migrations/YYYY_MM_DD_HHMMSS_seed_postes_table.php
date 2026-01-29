<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('postes')->insert([
            [
                'nom' => 'Non Traitées',
                'ordre' => 1,
                'duree_cible' => 15,
                'actif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Fonte',
                'ordre' => 2,
                'duree_cible' => 10,
                'actif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Moulage',
                'ordre' => 3,
                'duree_cible' => 20,
                'actif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Démoulage',
                'ordre' => 4,
                'duree_cible' => 5,
                'actif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Livraison',
                'ordre' => 5,
                'duree_cible' => 30,
                'actif' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        DB::table('postes')->truncate();
    }
};
