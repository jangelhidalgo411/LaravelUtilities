<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW VW_Generation AS
            SELECT DISTINCT
                CONCAT(
                    UCASE(left(Pokemons.Generation,1)),
                    LCASE(substr(Pokemons.Generation,2,2)),
                    '-',
                    UCASE(
                        RIGHT(Pokemons.Generation, OCTET_LENGTH(Pokemons.Generation) -
                        LOCATE('-',Pokemons.Generation))
                    )
                ) AS Generation
            FROM Pokemons
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS VW_Generation");
    }
};
