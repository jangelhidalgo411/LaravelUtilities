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
        Schema::create('PokemonMoveRelation', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->index('PokemonMoveRelation_Index_Pokemon_Id');
            $table->integer('Move_Id')->index('PokemonMoveRelation_Index_Move_Id');
            $table->integer('Move_Key');
            $table->integer('Learned_Level');
            $table->string('Learned_Method', 50);
            $table->string('Learned_In', 50);
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
        Schema::dropIfExists('PokemonMoveRelation');
    }
};
