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
        Schema::table('MagicColorIdentity', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicColorIdentity_FK_1')->references(['Card_Id'])->on('MagicCards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicColorIdentity', function (Blueprint $table) {
            $table->dropForeign('MagicColorIdentity_FK_1');
        });
    }
};
