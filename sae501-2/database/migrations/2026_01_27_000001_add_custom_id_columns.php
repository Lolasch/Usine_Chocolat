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
        // Ajouter id_chocolat à la table chocolats
        if (!Schema::hasColumn('chocolats', 'id_chocolat')) {
            Schema::table('chocolats', function (Blueprint $table) {
                $table->unsignedBigInteger('id_chocolat')->nullable()->after('id');
            });

            // Copier les valeurs de id vers id_chocolat
            DB::statement('UPDATE chocolats SET id_chocolat = id WHERE id_chocolat IS NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chocolats', function (Blueprint $table) {
            if (Schema::hasColumn('chocolats', 'id_chocolat')) {
                $table->dropColumn('id_chocolat');
            }
        });
    }
};
