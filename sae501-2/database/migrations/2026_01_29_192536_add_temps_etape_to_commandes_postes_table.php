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
        Schema::table('commandes_postes', function (Blueprint $table) {
            $table->integer('temps_etape')->default(0)->after('date_entree');
            // Optionnel : index pour les requêtes rapides sur le temps
            $table->index('temps_etape');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes_postes', function (Blueprint $table) {
            //
        });
    }
};
