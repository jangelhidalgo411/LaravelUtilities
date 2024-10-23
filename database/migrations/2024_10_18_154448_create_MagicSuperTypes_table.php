<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('MagicSuperTypes', function (Blueprint $table) {
            $table->integer('Super_Type_Id')->unique('Unique_Super_Type_Id');
            $table->string('Super_Type_Name', 50);
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
        Schema::dropIfExists('MagicSuperTypes');
    }
};
