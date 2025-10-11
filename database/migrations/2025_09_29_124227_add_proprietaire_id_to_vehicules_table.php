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
        // Migration désactivée car la colonne 'proprietaire_id' existe déjà.
        // Rien à faire ici.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rien à faire ici non plus.
    }
};


// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         // Cette colonne existe déjà dans la table 'vehicules', donc on ne fait rien ici.
//         // Schema::table('vehicules', function (Blueprint $table) {
//         //     $table->unsignedBigInteger('proprietaire_id')->after('id');
//         //     $table->foreign('proprietaire_id')->references('id')->on('utilisateurs')->onDelete('cascade');
//         // });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         // Pas besoin de supprimer la colonne, elle existe déjà.
//         // Schema::table('vehicules', function (Blueprint $table) {
//         //     $table->dropForeign(['proprietaire_id']);
//         //     $table->dropColumn('proprietaire_id');
//         // });
//     }
// };
