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

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Ne rien faire au rollback pour éviter de casser
    }
};
