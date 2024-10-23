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
        Schema::create('MagicCardsPrints', function (Blueprint $table) {
            $table->integer('Card_Id')->index('MagicCardsPrints_Index_Card_Id');
            $table->string('Set_Id', 10)->index('MagicCardsPrints_Index_Set_Id');
            $table->string('Card_Universal_Id', 150);
            $table->integer('Card_Set_Number');
            $table->string('Card_Artist')->nullable();
            $table->string('Card_Image_Url')->nullable();
            $table->dateTime('Created_Date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('MagicCardsPrints');
    }
};
