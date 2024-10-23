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
        Schema::table('MagicCardsPrints', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicCardsPrints_FK_1')->references(['Card_Id'])->on('MagicCards');
            $table->foreign(['Set_Id'], 'MagicCardsPrints_FK_2')->references(['Set_Id'])->on('MagicSets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicCardsPrints', function (Blueprint $table) {
            $table->dropForeign('MagicCardsPrints_FK_1');
            $table->dropForeign('MagicCardsPrints_FK_2');
        });
    }
};
