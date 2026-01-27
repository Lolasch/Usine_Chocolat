<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // D'abord, supprimer toutes les commandes existantes (pour éviter les contraintes)
        DB::table('commandes')->delete();
        
        // Ensuite, supprimer tous les chocolats
        DB::table('chocolats')->delete();

        // Réinitialiser l'auto-increment
        DB::statement('ALTER TABLE chocolats AUTO_INCREMENT = 1');

        // Insérer les 6 chocolats proprement
        DB::table('chocolats')->insert([
            [
                'nom' => 'Chocolat noir',
                'description' => 'Chocolat noir 70% cacao',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat noir aux amandes',
                'description' => 'Chocolat noir avec éclats d\'amandes',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat noir aux noisettes',
                'description' => 'Chocolat noir avec éclats de noisettes',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat au lait',
                'description' => 'Chocolat au lait onctueux',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat lait aux amandes',
                'description' => 'Chocolat au lait avec éclats d\'amandes',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'Chocolat lait aux noisettes',
                'description' => 'Chocolat au lait avec éclats de noisettes',
                'disponible' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Mettre à jour id_chocolat avec id pour tous les chocolats
        DB::statement('UPDATE chocolats SET id_chocolat = id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('chocolats')->delete();
    }
};
