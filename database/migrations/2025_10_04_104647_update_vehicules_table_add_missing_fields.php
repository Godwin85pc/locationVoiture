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
        Schema::table('vehicules', function (Blueprint $table) {
            // Vérifier si les colonnes n'existent pas avant de les ajouter
            if (!Schema::hasColumn('vehicules', 'description')) {
                $table->text('description')->nullable()->after('kilometrage');
            }
            
            if (!Schema::hasColumn('vehicules', 'created_at')) {
                $table->timestamps();
            }
            
            // Vérifier si la clé étrangère n'existe pas déjà
            if (Schema::hasColumn('vehicules', 'proprietaire_id')) {
                // Si la colonne existe mais pas la contrainte, ajouter seulement la contrainte
                try {
                    $table->foreign('proprietaire_id')->references('id')->on('utilisateurs')->onDelete('cascade');
                } catch (\Exception $e) {
                    // La contrainte existe probablement déjà
                }
            } else {
                // Si la colonne n'existe pas du tout
                $table->unsignedBigInteger('proprietaire_id')->after('id');
                $table->foreign('proprietaire_id')->references('id')->on('utilisateurs')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            // Supprimer la clé étrangère en premier
            try {
                $table->dropForeign(['proprietaire_id']);
            } catch (\Exception $e) {
                // Ignorer si la contrainte n'existe pas
            }
            
            // Supprimer les colonnes si elles existent
            $columnsToCheck = ['description', 'created_at', 'updated_at'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('vehicules', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
