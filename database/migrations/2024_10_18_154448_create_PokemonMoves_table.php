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
        Schema::create('PokemonMoves', function (Blueprint $table) {
            $table->integer('Move_Id')->unique('Unique_Move_Id');
            $table->string('Move_Name', 50);
            $table->string('Generation', 50);
            $table->integer('Move_Accuracy')->nullable();
            $table->integer('Move_Power')->nullable();
            $table->integer('Move_PP')->nullable();
            $table->integer('Move_Priority');
            $table->integer('Move_Type');
            $table->string('Move_Target', 50);
            $table->string('Move_DamageClass', 50);
            $table->text('Move_Effect')->nullable();
            $table->text('Move_Flavor')->nullable();
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
        Schema::dropIfExists('PokemonMoves');
    }
};
