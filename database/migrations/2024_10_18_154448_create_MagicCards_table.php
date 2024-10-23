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
        Schema::create('MagicCards', function (Blueprint $table) {
            $table->integer('Card_Id')->unique('Unique_Card_Id');
            $table->string('Card_Name', 150)->unique('Unique_Card_Name');
            $table->string('Card_Type', 150);
            $table->string('Card_Rarity', 10);
            $table->string('Card_Layout', 10);
            $table->integer('Card_CMC');
            $table->text('Card_Text');
            $table->string('Card_Mana_Cost', 50)->nullable();
            $table->integer('Card_Life')->default(0);
            $table->integer('Card_Loyalty')->default(0);
            $table->string('Card_Power', 5)->default('0');
            $table->string('Card_Toughness', 5)->default('0');
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
        Schema::dropIfExists('MagicCards');
    }
};
