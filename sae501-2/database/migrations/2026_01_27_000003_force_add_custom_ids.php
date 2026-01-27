<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Forcer l'ajout de id_visiteur si elle n'existe pas
        try {
            Schema::table('visiteurs', function (Blueprint $table) {
                if (!Schema::hasColumn('visiteurs', 'id_visiteur')) {
                    $table->unsignedBigInteger('id_visiteur')->nullable()->after('id');
                }
            });
            DB::statement('UPDATE visiteurs SET id_visiteur = id WHERE id_visiteur IS NULL OR id_visiteur = 0');
        } catch (\Exception $e) {
            // Colonne existe déjà
        }

        // Forcer l'ajout de id_chocolat si elle n'existe pas
        try {
            Schema::table('chocolats', function (Blueprint $table) {
                if (!Schema::hasColumn('chocolats', 'id_chocolat')) {
                    $table->unsignedBigInteger('id_chocolat')->nullable()->after('id');
                }
            });
            DB::statement('UPDATE chocolats SET id_chocolat = id WHERE id_chocolat IS NULL OR id_chocolat = 0');
        } catch (\Exception $e) {
            // Colonne existe déjà
        }

        // Forcer l'ajout de id_commande si elle n'existe pas
        try {
            Schema::table('commandes', function (Blueprint $table) {
                if (!Schema::hasColumn('commandes', 'id_commande')) {
                    $table->unsignedBigInteger('id_commande')->nullable()->after('id');
                }
            });
            DB::statement('UPDATE commandes SET id_commande = id WHERE id_commande IS NULL OR id_commande = 0');
        } catch (\Exception $e) {
            // Colonne existe déjà
        }

        // Forcer l'ajout de id_email si elle n'existe pas
        try {
            Schema::table('emails', function (Blueprint $table) {
                if (!Schema::hasColumn('emails', 'id_email')) {
                    $table->unsignedBigInteger('id_email')->nullable()->after('id');
                }
            });
            DB::statement('UPDATE emails SET id_email = id WHERE id_email IS NULL OR id_email = 0');
        } catch (\Exception $e) {
            // Colonne existe déjà
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ne rien faire au rollback pour éviter de casser
    }
};
