<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Vérifier si les colonnes n'existent pas déjà
            if (!Schema::hasColumn('reservations', 'pack')) {
                $table->string('pack')->default('standard')->after('montant_total');
            }
            if (!Schema::hasColumn('reservations', 'nom')) {
                $table->string('nom', 100)->nullable()->after('pack');
            }
            if (!Schema::hasColumn('reservations', 'prenom')) {
                $table->string('prenom', 100)->nullable()->after('nom');
            }
            if (!Schema::hasColumn('reservations', 'email')) {
                $table->string('email')->nullable()->after('prenom');
            }
            if (!Schema::hasColumn('reservations', 'telephone')) {
                $table->string('telephone', 20)->nullable()->after('email');
            }
            if (!Schema::hasColumn('reservations', 'motif_rejet')) {
                $table->text('motif_rejet')->nullable()->after('telephone');
            }
            
            // Ajouter timestamps si pas présents
            if (!Schema::hasColumn('reservations', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $columnsToCheck = ['pack', 'nom', 'prenom', 'email', 'telephone', 'motif_rejet'];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('reservations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};