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
        // Ajouter id_visiteur à la table visiteurs
        if (!Schema::hasColumn('visiteurs', 'id_visiteur')) {
            Schema::table('visiteurs', function (Blueprint $table) {
                $table->unsignedBigInteger('id_visiteur')->nullable()->after('id');
            });
            
            // Copier les valeurs de id vers id_visiteur
            DB::statement('UPDATE visiteurs SET id_visiteur = id WHERE id_visiteur IS NULL');
        }

        // Ajouter id_chocolat à la table chocolats
        if (!Schema::hasColumn('chocolats', 'id_chocolat')) {
            Schema::table('chocolats', function (Blueprint $table) {
                $table->unsignedBigInteger('id_chocolat')->nullable()->after('id');
            });
            
            // Copier les valeurs de id vers id_chocolat
            DB::statement('UPDATE chocolats SET id_chocolat = id WHERE id_chocolat IS NULL');
        }

        // Ajouter id_commande à la table commandes
        if (!Schema::hasColumn('commandes', 'id_commande')) {
            Schema::table('commandes', function (Blueprint $table) {
                $table->unsignedBigInteger('id_commande')->nullable()->after('id');
            });
            
            // Copier les valeurs de id vers id_commande
            DB::statement('UPDATE commandes SET id_commande = id WHERE id_commande IS NULL');
        }

        // Ajouter id_email à la table emails
        if (!Schema::hasColumn('emails', 'id_email')) {
            Schema::table('emails', function (Blueprint $table) {
                $table->unsignedBigInteger('id_email')->nullable()->after('id');
            });
            
            // Copier les valeurs de id vers id_email
            DB::statement('UPDATE emails SET id_email = id WHERE id_email IS NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visiteurs', function (Blueprint $table) {
            if (Schema::hasColumn('visiteurs', 'id_visiteur')) {
                $table->dropColumn('id_visiteur');
            }
        });

        Schema::table('chocolats', function (Blueprint $table) {
            if (Schema::hasColumn('chocolats', 'id_chocolat')) {
                $table->dropColumn('id_chocolat');
            }
        });

        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'id_commande')) {
                $table->dropColumn('id_commande');
            }
        });

        Schema::table('emails', function (Blueprint $table) {
            if (Schema::hasColumn('emails', 'id_email')) {
                $table->dropColumn('id_email');
            }
        });
    }
};
