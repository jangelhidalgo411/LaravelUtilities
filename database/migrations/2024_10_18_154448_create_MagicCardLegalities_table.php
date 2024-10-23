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
        Schema::create('MagicCardLegalities', function (Blueprint $table) {
            $table->integer('Card_Id')->index('MagicFormatRelation_Index_Card_Id');
            $table->integer('Format_Id')->index('MagicFormatRelation_Index_Format_Id');
            $table->string('Format_Legality', 15);
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
        Schema::dropIfExists('MagicCardLegalities');
    }
};
