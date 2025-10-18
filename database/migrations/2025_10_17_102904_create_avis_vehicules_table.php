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
    Schema::create('avis', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('utilisateur_id');
        $table->unsignedBigInteger('vehicule_id');
        $table->tinyInteger('note'); // 1 à 5
        $table->text('commentaire')->nullable();
        $table->timestamps();

        $table->foreign('utilisateur_id')
              ->references('id')->on('utilisateurs')
              ->onDelete('cascade');

        $table->foreign('vehicule_id')
              ->references('id')->on('vehicules')
              ->onDelete('cascade');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis_vehicules');
    }
};
