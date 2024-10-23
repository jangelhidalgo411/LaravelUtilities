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
        Schema::create('MagicSuperTypeRelation', function (Blueprint $table) {
            $table->integer('Card_Id')->index('MagicSuperTypeRelation_Index_Card_Id');
            $table->integer('Super_Type_Id')->index('MagicSuperTypeRelation_Index_Super_Type_Id');
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
        Schema::dropIfExists('MagicSuperTypeRelation');
    }
};
