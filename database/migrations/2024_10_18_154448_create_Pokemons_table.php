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
        Schema::create('Pokemons', function (Blueprint $table) {
            $table->integer('Pokemon_Id')->unique('Unique_Pokemon_Id');
            $table->string('Pokemon_Name', 50);
            $table->string('Pokemon_Color', 50);
            $table->string('Generation', 50);
            $table->string('Growth', 50);
            $table->string('Back_Default')->nullable();
            $table->string('Back_Female')->nullable();
            $table->string('Back_Shiny_Default')->nullable();
            $table->string('Back_Shiny_Female')->nullable();
            $table->string('Front_Default')->nullable();
            $table->string('Front_Female')->nullable();
            $table->string('Front_Shiny_Default')->nullable();
            $table->string('Front_Shiny_Female')->nullable();
            $table->boolean('Is_Default')->default(false);
            $table->boolean('Forms_Switchable')->default(false);
            $table->boolean('Gender_Diff')->default(false);
            $table->boolean('Is_Baby')->default(false);
            $table->boolean('Is_Legendary')->default(false);
            $table->boolean('Is_Mythical');
            $table->double('Height');
            $table->double('Weight');
            $table->integer('Base_Experience');
            $table->integer('Base_Happiness')->nullable();
            $table->integer('Capture_Rate');
            $table->integer('Gender_Rate');
            $table->integer('Hatch_Steps');
            $table->integer('Pre')->nullable();
            $table->integer('Shape')->nullable();
            $table->integer('HP');
            $table->integer('HP_Effort');
            $table->integer('Attack');
            $table->integer('Attack_Effort');
            $table->integer('Defense');
            $table->integer('Defense_Effort');
            $table->integer('Special_Attack');
            $table->integer('Special_Attack_Effort');
            $table->integer('Special_Defense');
            $table->integer('Special_Defense_Effort');
            $table->integer('Speed');
            $table->integer('Speed_Effort');
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
        Schema::dropIfExists('Pokemons');
    }
};
