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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande', 50);
            $table->foreignId('visiteur_id')->nullable()->constrained('visiteurs');
            $table->foreignId('chocolat_id')->constrained('chocolats');
            $table->string('allergie', 255)->nullable();
            $table->dateTime('date_commande_debut')->useCurrent();
            $table->dateTime('date_commande_fin')->nullable();
            $table->string('statut', 50)->default('en_production');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
