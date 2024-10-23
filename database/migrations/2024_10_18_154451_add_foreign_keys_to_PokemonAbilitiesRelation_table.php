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
        Schema::table('PokemonAbilitiesRelation', function (Blueprint $table) {
            $table->foreign(['Ability_Id'], 'PokemonAbilitiesRelation_FK_1')->references(['Ability_Id'])->on('PokemonAbilities');
            $table->foreign(['Pokemon_Id'], 'PokemonAbilitiesRelation_FK_2')->references(['Pokemon_Id'])->on('Pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PokemonAbilitiesRelation', function (Blueprint $table) {
            $table->dropForeign('PokemonAbilitiesRelation_FK_1');
            $table->dropForeign('PokemonAbilitiesRelation_FK_2');
        });
    }
};
