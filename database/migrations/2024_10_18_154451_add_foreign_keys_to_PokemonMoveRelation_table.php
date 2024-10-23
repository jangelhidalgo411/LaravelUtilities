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
        Schema::table('PokemonMoveRelation', function (Blueprint $table) {
            $table->foreign(['Move_Id'], 'PokemonMoveRelation_FK_1')->references(['Move_Id'])->on('PokemonMoves');
            $table->foreign(['Pokemon_Id'], 'PokemonMoveRelation_FK_2')->references(['Pokemon_Id'])->on('Pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PokemonMoveRelation', function (Blueprint $table) {
            $table->dropForeign('PokemonMoveRelation_FK_1');
            $table->dropForeign('PokemonMoveRelation_FK_2');
        });
    }
};
