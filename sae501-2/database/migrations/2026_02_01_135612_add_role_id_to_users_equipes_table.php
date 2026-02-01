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
        Schema::table('users_equipes', function (Blueprint $table) {
            $table->foreignId('role_id')->default(2)->after('poste_id')->constrained('roles')->cascadeOnDelete();
        });

        // Copier les rôles existants de la table users vers users_equipes
        DB::statement('UPDATE users_equipes ue INNER JOIN users u ON ue.user_id = u.id SET ue.role_id = u.role_id');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_equipes', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
};
