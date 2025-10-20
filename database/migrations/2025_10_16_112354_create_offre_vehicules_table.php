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
        Schema::create('offre_vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('categorie');
            $table->string('etat');
            $table->float('note')->nullable();
            $table->string('transmission');
            $table->boolean('climatisation')->default(true);
            $table->integer('portes');
            $table->integer('places');
            $table->string('carburant');
            $table->integer('kilometrage');
            $table->text('image')->nullable();
            $table->json('packs')->nullable();      // Ex: [{nom: "PACK STANDARD", prix: 151, options: ["Assurance", "Annulation"]}]
            $table->json('options')->nullable();    // Ex: ["Responsabilité civile", "Assurance tous risques"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre_vehicules');
    }
};
