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
        Schema::create('PokemonTypeRelation', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->index('PokemonTypeRelation_Index_Pokemon_Id');
            $table->integer('Type_Id')->index('PokemonTypeRelation_Index_Type_Id');
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
        Schema::dropIfExists('PokemonTypeRelation');
    }
};
