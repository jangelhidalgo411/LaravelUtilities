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
        Schema::create('MagicSubTypes', function (Blueprint $table) {
            $table->integer('Sub_Type_Id')->unique('Unique_Sub_Type_Id');
            $table->string('Sub_Type_Name', 50);
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
        Schema::dropIfExists('MagicSubTypes');
    }
};
