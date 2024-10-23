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
        Schema::table('PokemonTypeRelation', function (Blueprint $table) {
            $table->foreign(['Type_Id'], 'PokemonTypeRelation_FK_1')->references(['Type_Id'])->on('PokemonTypes');
            $table->foreign(['Pokemon_Id'], 'PokemonTypeRelation_FK_2')->references(['Pokemon_Id'])->on('Pokemons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PokemonTypeRelation', function (Blueprint $table) {
            $table->dropForeign('PokemonTypeRelation_FK_1');
            $table->dropForeign('PokemonTypeRelation_FK_2');
        });
    }
};
