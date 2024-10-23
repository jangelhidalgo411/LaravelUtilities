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
        Schema::create('MagicRulings', function (Blueprint $table) {
            $table->integer('Card_Id')->index('MagicFormatRelation_Index_Card_Id');
            $table->dateTime('Ruling_Date');
            $table->text('Ruling_Text');
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
        Schema::dropIfExists('MagicRulings');
    }
};
