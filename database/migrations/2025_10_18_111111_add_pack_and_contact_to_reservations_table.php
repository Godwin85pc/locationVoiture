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
            
            // Renommer client_id en utilisateur_id si nécessaire
            if (Schema::hasColumn('reservations', 'client_id') && !Schema::hasColumn('reservations', 'utilisateur_id')) {
                $table->renameColumn('client_id', 'utilisateur_id');
            }
            
            // Renommer montant_total en prix_total si nécessaire
            if (Schema::hasColumn('reservations', 'montant_total') && !Schema::hasColumn('reservations', 'prix_total')) {
                $table->renameColumn('montant_total', 'prix_total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['pack', 'nom', 'prenom', 'email', 'telephone']);
        });
    }
};