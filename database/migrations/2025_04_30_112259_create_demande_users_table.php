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
        Schema::create('demande_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('demande_id')->constrained()->onDelete('cascade');
            $table->string('etat_demande')->default('en attente'); // Etat de la demande (en attente, acceptée, refusée)
            $table->string('date_reponce_demande')->nullable(); // Date de réponse à la demande
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demande_users');
    }
};
