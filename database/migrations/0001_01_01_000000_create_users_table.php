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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('prenom')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->integer('nombre_enfants')->nullable();
            $table->string('adresse')->nullable();
            $table->string('telephone')->nullable();
            $table->string('sexe')->nullable();
            $table->string('cni')->nullable();
            $table->decimal('salaire', 10, 2)->nullable();
            $table->date('date_debut_contrat')->nullable();
            $table->date('date_fin_contrat')->nullable();
            $table->date('date_debut_essai')->nullable();
            $table->date('date_fin_essai')->nullable();
            $table->unsignedBigInteger('poste_id')->nullable();
            $table->unsignedBigInteger('equipe_id')->nullable();
            $table->string('disponibilite_user')->default('disponible');
            $table->string('presence_absence')->default('absent');
            $table->rememberToken();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('poste_id')->references('id')->on('postes')->onDelete('set null');
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('set null');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
