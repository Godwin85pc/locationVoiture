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
        Schema::table('vehicules', function (Blueprint $table) {
            // Ajouter la colonne description si elle n'existe pas
            if (!Schema::hasColumn('vehicules', 'description')) {
                $table->text('description')->nullable()->after('kilometrage');
            }

            // Ajouter created_at / updated_at si elles n'existent pas
            if (!Schema::hasColumn('vehicules', 'created_at')) {
                $table->timestamps();
            }

            // Modifier les statuts pour inclure les nouveaux statuts admin
            if (Schema::hasColumn('vehicules', 'statut')) {
                DB::statement("ALTER TABLE vehicules MODIFY COLUMN statut ENUM('disponible', 'reserve', 'en_location', 'maintenance', 'en_attente', 'rejete', 'loue') DEFAULT 'en_attente'");
            }

            // Ajouter motif_rejet pour les rejets admin
            if (!Schema::hasColumn('vehicules', 'motif_rejet')) {
                $table->text('motif_rejet')->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées
            $columnsToCheck = ['description', 'created_at', 'updated_at', 'motif_rejet'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('vehicules', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};