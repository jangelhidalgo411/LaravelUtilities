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
        Schema::table('MagicSubTypeRelation', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicSubTypeRelation_FK_1')->references(['Card_Id'])->on('MagicCards');
            $table->foreign(['Sub_Type_Id'], 'MagicSubTypeRelation_FK_2')->references(['Sub_Type_Id'])->on('MagicSubTypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicSubTypeRelation', function (Blueprint $table) {
            $table->dropForeign('MagicSubTypeRelation_FK_1');
            $table->dropForeign('MagicSubTypeRelation_FK_2');
        });
    }
};
