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
        Schema::table('MagicTypeRelation', function (Blueprint $table) {
            $table->foreign(['Card_Id'], 'MagicTypeRelation_FK_1')->references(['Card_Id'])->on('MagicCards');
            $table->foreign(['Type_Id'], 'MagicTypeRelation_FK_2')->references(['Type_Id'])->on('MagicTypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('MagicTypeRelation', function (Blueprint $table) {
            $table->dropForeign('MagicTypeRelation_FK_1');
            $table->dropForeign('MagicTypeRelation_FK_2');
        });
    }
};
