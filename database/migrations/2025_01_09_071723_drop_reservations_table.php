<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropReservationsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('reservations'); // Supprime la table reservations
    }

    public function down()
    {
        // Optionnel : vous pouvez recréer la table ici si nécessaire
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // Ajoutez ici les colonnes de la table
            $table->timestamps();
        });
    }
}
