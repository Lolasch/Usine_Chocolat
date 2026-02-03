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
        Schema::disableForeignKeyConstraints();

        DB::table('roles')->insertOrIgnore([
            [
                'nom' => 'superviseur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nom' => 'operateur',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
