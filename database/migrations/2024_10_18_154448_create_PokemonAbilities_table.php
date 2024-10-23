<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('PokemonAbilities', function (Blueprint $table) {
            $table->integer('Ability_Id')->unique('Unique_Ability_Id');
            $table->string('Ability_Name', 50);
            $table->string('Generation', 50);
            $table->boolean('Is_Main_Serie');
            $table->text('Ability_Effect')->nullable();
            $table->text('Ability_Entry')->nullable();
            $table->text('Ability_Flavor')->nullable();
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
        Schema::dropIfExists('PokemonAbilities');
    }
};
