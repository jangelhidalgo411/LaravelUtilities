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
        Schema::create('PokemonHabitats', function (Blueprint $table) {
            $table->integer('Habitat_Id', true)->unique('Unique_Habitat_Id');
            $table->string('Habitat_Name', 50);
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
        Schema::dropIfExists('PokemonHabitats');
    }
};
