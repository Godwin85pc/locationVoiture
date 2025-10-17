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
        Schema::table('offre_vehicules', function (Blueprint $table) {
            // Ajouter les champs pour les offres d'agence
            $table->unsignedBigInteger('vehicule_id')->nullable()->after('id');
            $table->decimal('prix_par_jour', 10, 2)->nullable()->after('vehicule_id');
            $table->text('description_offre')->nullable()->after('prix_par_jour');
            $table->date('date_debut_offre')->nullable()->after('description_offre');
            $table->date('date_fin_offre')->nullable()->after('date_debut_offre');
            $table->decimal('reduction_pourcentage', 5, 2)->default(0)->after('date_fin_offre');
            $table->text('conditions_speciales')->nullable()->after('reduction_pourcentage');
            $table->enum('statut', ['active', 'inactive', 'expired'])->default('active')->after('conditions_speciales');
            $table->unsignedBigInteger('created_by')->nullable()->after('statut');
            
            // Créer les clés étrangères
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('utilisateurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offre_vehicules', function (Blueprint $table) {
            // Supprimer les clés étrangères d'abord
            $table->dropForeign(['vehicule_id']);
            $table->dropForeign(['created_by']);
            
            // Supprimer les colonnes
            $table->dropColumn([
                'vehicule_id',
                'prix_par_jour',
                'description_offre',
                'date_debut_offre',
                'date_fin_offre',
                'reduction_pourcentage',
                'conditions_speciales',
                'statut',
                'created_by'
            ]);
        });
    }
};
