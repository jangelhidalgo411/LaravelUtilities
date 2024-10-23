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
        Schema::table('PokemonEggRelation', function (Blueprint $table) {
            $table->foreign(['Egg_Id'], 'PokemonEggRelation_FK_1')->references(['Egg_Id'])->on('PokemonEggs');
            $table->foreign(['Pokemon_Id'], 'PokemonEggRelation_FK_2')->references(['Pokemon_Id'])->on('Pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PokemonEggRelation', function (Blueprint $table) {
            $table->dropForeign('PokemonEggRelation_FK_1');
            $table->dropForeign('PokemonEggRelation_FK_2');
        });
    }
};
