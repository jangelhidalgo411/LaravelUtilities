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
        Schema::table('MagicColor', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicColor_FK_1')->references(['Card_Id'])->on('MagicCards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicColor', function (Blueprint $table) {
            $table->dropForeign('MagicColor_FK_1');
        });
    }
};
