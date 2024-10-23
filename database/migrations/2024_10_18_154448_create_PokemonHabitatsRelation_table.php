<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('PokemonHabitatRelation', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->index('PokemonHabitatRelation_Index_Pokemon_Id');
            $table->integer('Habitat_Id')->index('PokemonHabitatRelation_Index_Habitat_Id');
            $table->integer('Move_Key');
            $table->dateTime('Created_Date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('PokemonHabitatRelation');
    }
};
