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
        Schema::create('PokemonEggRelation', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->index('PokemonEggRelation_Index_Pokemon_Id');
            $table->integer('Egg_Id')->index('PokemonEggRelation_Index_Egg_Id');
            $table->integer('Slot');
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
        Schema::dropIfExists('pokemoneggrelation');
    }
};
