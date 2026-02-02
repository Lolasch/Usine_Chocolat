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
        Schema::table('non_conformites', function (Blueprint $table) {
            // Type de non-conformité
            $table->enum('type', [
                'qualite',
                'poids',
                'quantite',
                'emballage',
                'casse'
            ])->after('commande_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('non_conformite', function (Blueprint $table) {
            //
        });
    }
};
