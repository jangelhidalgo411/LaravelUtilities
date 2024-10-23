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
        Schema::create('MagicSets', function (Blueprint $table) {
            $table->string('Set_Id', 10)->unique('Unique_Set_Id');
            $table->string('Set_Name', 75);
            $table->string('Set_Type', 25);
            $table->string('Set_Block', 50);
            $table->boolean('Set_Online_Only');
            $table->dateTime('Set_Release_Date');
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
        Schema::dropIfExists('MagicSets');
    }
};
