<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicule_id');
            $table->unsignedBigInteger('client_id'); // correspond à utilisateur_id
            $table->date('date_debut');
            $table->date('date_fin');
            $table->decimal('montant_total', 10, 2);
            $table->enum('pack', ['standard','premium'])->default('standard');
            $table->enum('statut', ['en_attente','confirmee','annulee','terminee'])->default('en_attente');
            $table->string('lieu_recuperation', 255)->nullable();
            $table->string('lieu_restitution', 255)->nullable();

            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('utilisateurs')->onDelete('cascade');

            $table->timestamps(); // <-- ajoute les colonnes created_at et updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
