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
        Schema::table('taches', function (Blueprint $table) {
            $table->dropForeign(['type_tache_id']); // supprime la contrainte
            $table->dropColumn('type_tache_id');    // supprime la colonne
        });

        Schema::dropIfExists('type_taches');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('taches', function (Blueprint $table) {
            $table->foreignId('type_tache_id')->nullable()->constrained('type_taches')->onDelete('cascade');
        });

        Schema::create('type_taches', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });
    }
};
