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
    public function up() {
        DB::statement("
            CREATE VIEW VW_PokemonData AS
                SELECT
                    CONCAT(SPE.Species_Id,' ',SPE.Species_Name) AS Species,
                    ifnull(SPE.Species_Id,POK.Pokemon_Id) AS Species_Id,
                    POK.Pokemon_Name AS Pokemon_Name,
                    POK.Pokemon_Color AS Pokemon_Color,
                    CONCAT(
                        UCASE(LEFT(POK.Generation,1)),
                        LCASE(substr(POK.Generation,2,2)),
                        '-',
                        UCASE(
                            RIGHT(POK.Generation, OCTET_LENGTH(POK.Generation) - LOCATE('-',POK.Generation))
                        )
                    ) AS Generation,
                    POK.Growth AS Growth,
                    GROUP_CONCAT(PTY.Type_Name order by PTR.Slot ASC SEPARATOR '-') AS Pokemon_Type,
                    POK.Is_Legendary AS Is_Legendary,
                    POK.Is_Mythical AS Is_Mythical,
                    POK.Height AS Height,
                    POK.Weight AS Weight,
                    POK.Gender_Diff AS Gender_Diff
                FROM Pokemons POK
                LEFT join PokemonSpecies AS SPE ON SPE.Species_Id = POK.Pokemon_Id
                LEFT join PokemonTypeRelation AS PTR ON PTR.Pokemon_Id = POK.Pokemon_Id
                LEFT join PokemonTypes AS PTY ON PTY.Type_Id = PTR.Type_Id
            GROUP BY
                    CONCAT(SPE.Species_Id,' ',SPE.Species_Name),
                    ifnull(SPE.Species_Id,POK.Pokemon_Id),
                    POK.Pokemon_Name,
                    POK.Pokemon_Color,
                    POK.Generation,
                    POK.Growth,
                    POK.Is_Legendary,
                    POK.Is_Mythical,
                    POK.Height,
                    POK.Weight,
                    POK.Gender_Diff
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        DB::statement("DROP VIEW IF EXISTS VW_PokemonData");
    }
};
