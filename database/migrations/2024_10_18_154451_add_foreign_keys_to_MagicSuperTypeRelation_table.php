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
        Schema::table('MagicSuperTypeRelation', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicSuperTypeRelation_FK_1')->references(['Card_Id'])->on('MagicCards');
            $table->foreign(['Super_Type_Id'], 'MagicSuperTypeRelation_FK_2')->references(['Super_Type_Id'])->on('MagicSuperTypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicSuperTypeRelation', function (Blueprint $table) {
            $table->dropForeign('MagicSuperTypeRelation_FK_1');
            $table->dropForeign('MagicSuperTypeRelation_FK_2');
        });
    }
};
