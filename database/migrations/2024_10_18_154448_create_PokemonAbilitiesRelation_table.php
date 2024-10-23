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
        Schema::create('PokemonAbilitiesRelation', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->index('PokemonAbilitiesRelation_Index_Pokemon_Id');
            $table->integer('Ability_Id')->index('PokemonAbilitiesRelation_Index_Ability_Id');
            $table->integer('Slot');
            $table->boolean('Is_Hidden');
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
        Schema::dropIfExists('PokemonAbilitiesRelation');
    }
};
