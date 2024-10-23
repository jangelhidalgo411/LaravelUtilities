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
    public function up() {
        Schema::table('PokemonHabitatRelation', function (Blueprint $table) {
            $table->foreign(['Habitat_Id'], 'PokemonHabitatRelation_FK_1')->references(['Habitat_Id'])->on('PokemonHabitats');
            $table->foreign(['Pokemon_Id'], 'PokemonHabitatRelation_FK_2')->references(['Pokemon_Id'])->on('Pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PokemonHabitatRelation', function (Blueprint $table) {
            $table->dropForeign('PokemonHabitatRelation_FK_1');
            $table->dropForeign('PokemonHabitatRelation_FK_2');
        });
    }
};
