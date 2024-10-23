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
        Schema::table('MagicCardLegalities', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicCardLegalities_FK_1')->references(['Card_Id'])->on('MagicCards');
            $table->foreign(['Format_Id'], 'MagicCardLegalities_FK_2')->references(['Format_Id'])->on('MagicFormats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicCardLegalities', function (Blueprint $table) {
            $table->dropForeign('MagicCardLegalities_FK_1');
            $table->dropForeign('MagicCardLegalities_FK_2');
        });
    }
};
