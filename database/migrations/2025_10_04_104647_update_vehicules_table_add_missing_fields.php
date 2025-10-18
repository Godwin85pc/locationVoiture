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

            // Ajouter proprietaire_id seulement si elle n'existe pas
            if (!Schema::hasColumn('vehicules', 'proprietaire_id')) {
                $table->unsignedBigInteger('proprietaire_id')->after('id');
            }

            // Ajouter la clé étrangère seulement si elle n'existe pas
            $fkExists = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'vehicules' 
                  AND COLUMN_NAME = 'proprietaire_id' 
                  AND REFERENCED_TABLE_NAME = 'utilisateurs'
            ");

            if (empty($fkExists)) {
                $table->foreign('proprietaire_id')
                      ->references('id')
                      ->on('utilisateurs')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicules', function (Blueprint $table) {
            // Supprimer la clé étrangère si elle existe
            try {
                $table->dropForeign(['proprietaire_id']);
            } catch (\Exception $e) {
                // ignorer si la contrainte n'existe pas
            }

            // Supprimer les colonnes ajoutées
            $columnsToCheck = ['description', 'created_at', 'updated_at'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('vehicules', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
