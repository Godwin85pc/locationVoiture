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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            
            $table->string('marque', 100);
            $table->string('modele', 100);
            $table->enum('type', ['SUV', 'Berline', 'Utilitaire', 'Citadine']);
            $table->string('immatriculation', 50)->unique();
            $table->decimal('prix_jour', 10, 2);
            $table->enum('statut', ['disponible', 'reserve', 'en_location', 'maintenance'])->default('disponible');
            $table->enum('carburant', ['Essence','Diesel','Electrique'])->default('Essence');
            $table->integer('nbre_places')->default(4);
            $table->string('localisation', 255)->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamp('date_ajout')->useCurrent();
            $table->integer('kilometrage')->default(0);
            $table->foreign('proprietaire_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
