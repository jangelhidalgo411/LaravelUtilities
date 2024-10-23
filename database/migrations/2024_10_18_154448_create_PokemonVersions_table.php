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
        Schema::create('PokemonVersions', function (Blueprint $table) {
            $table->integer('Version_Id')->unique('Unique_Version_Id');
            $table->string('Version_Name', 50);
            $table->string('Generation', 50);
            $table->string('Version_Group', 50);
            $table->boolean('Kanto')->default(false);
            $table->boolean('Johto')->default(false);
            $table->boolean('Hoenn')->default(false);
            $table->boolean('Sinnoh')->default(false);
            $table->boolean('Unova')->default(false);
            $table->boolean('Kalos')->default(false);
            $table->boolean('Alola')->default(false);
            $table->boolean('Galar')->default(false);
            $table->boolean('Hisui')->default(false);
            $table->boolean('Paldea')->default(false);
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
        Schema::dropIfExists('PokemonVersions');
    }
};
