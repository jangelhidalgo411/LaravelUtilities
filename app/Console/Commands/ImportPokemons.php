<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImportPokemons extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Pokemon:Import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Pokemon Using Pokemon API to be used from DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle() {
        $this->GetAllPokemonSpecies();
        $this->GetAllPokemonEggs();
        $this->GetAllPokemonTypes();
        $this->GetAllPokemonHabitats();
        $this->GetAllPokemonShape();
        $this->GetAllPokemonAbilities();
        $this->GetAllPokemonMoves();
        $this->GetAllPokemonGames();
        $this->GetAllPokemonList('https://pokeapi.co/api/v2/pokemon/?offset=0&limit=500');

        $this->info("-- Pokemons Import completed --");
    }

    //Get All pokemon Species
    public function GetAllPokemonSpecies() {
        $this->info("-- Import Pokemon Species --");
        $ClientSpecies = new Client(['verify' => false]);
        $PokemonSpecies = json_decode($ClientSpecies->get("https://pokeapi.co/api/v2/pokemon-species?offset=0&limit=20000")->getBody()->getContents())->results;

        foreach ($PokemonSpecies as $Key => $Specie) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;

            $MainData['Species_Name'] = $Specie->name;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonSpecies', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info(($Key+1)." ".$Specie->name." - ".$Msg);            
        }
    }

    //Get All pokemon Eggs
    public function GetAllPokemonEggs() {
        $this->info("-- Import Pokemon Eggs --");
        $ClientEggs = new Client(['verify' => false]);
        $EggGroups = json_decode($ClientEggs->get("https://pokeapi.co/api/v2/egg-group")->getBody()->getContents())->results;

        foreach ($EggGroups as $Key => $EggGroup) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;

            $MainData['Egg_Name'] = $EggGroup->name;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');
 
            $Msg = AddRecord('PokemonEggs', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info(($Key+1)." ".$EggGroup->name." - ".$Msg);            
        }
    }

    //Get All pokemon Types
    public function GetAllPokemonTypes() {
        $this->info("-- Import Pokemon Types --");
        $ClientTypes = new Client(['verify' => false]);
        $Types = json_decode($ClientTypes->get("https://pokeapi.co/api/v2/type/?offset=0&limit=50")->getBody()->getContents())->results;

        foreach ($Types as $Key => $Type) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;

            $MainData['Type_Name'] = $Type->name;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonTypes', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info(($Key+1)." ".$Type->name." - ".$Msg);            
        }
    }

    //Get All pokemon Eggs
    public function GetAllPokemonHabitats() {
        $this->info("-- Import Pokemon Habitats --");
        $ClientHabitats = new Client(['verify' => false]);
        $Habitats = json_decode($ClientHabitats->get("https://pokeapi.co/api/v2/pokemon-habitat/")->getBody()->getContents())->results;

        foreach ($Habitats as $Key => $Habitat) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;
            $MainData['Habitat_Name'] = $Habitat->name;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonHabitats', $MainData, $OptionalData, $AlloWUpdate);

            $ClientHabitatList = new Client(['verify' => false]);
            $HabitatInfo = json_decode($ClientHabitatList->get($Habitat->url)->getBody()->getContents());

            foreach ($HabitatInfo->pokemon_species as $HKey => $Specie) {
                $MainHabitatData = $OptionalHabitatData =[];

                $MainHabitatData['Pokemon_id'] = DB::table('pokemonspecies')->where([['Species_Name', $Specie->name]])->first()->Species_Id;
                $MainHabitatData['Habitat_id'] = DB::table('PokemonHabitats')->where([['Habitat_Name', $Habitat->name]])->first()->Habitat_Id;
                $OptionalHabitatData['Move_Key'] = $HKey;

                AddRecord('PokemonHabitatRelation', $MainHabitatData, $OptionalHabitatData, $AlloWUpdate);
            }

            
            $this->info(($Key+1)." ".$Habitat->name." - ".$Msg);            
        }
    }

    //Get All pokemon Shape
    public function GetAllPokemonShape() {
        $this->info("-- Import Pokemon Shape --");
        $ClientShape = new Client(['verify' => false]);
        $Shapes = json_decode($ClientShape->get("https://pokeapi.co/api/v2/pokemon-shape")->getBody()->getContents())->results;

        foreach ($Shapes as $Key => $Shape) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;

            $MainData['Shape_Name'] = $Shape->name;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonShape', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info(($Key+1)." ".$Shape->name." - ".$Msg);            
        }
    }

    //Get All pokemon Abilities
    public function GetAllPokemonAbilities() {
        $this->info("-- Import Pokemon Abilities --");
        $ClientAbilities = new Client(['verify' => false]);
        $Abilities = json_decode($ClientAbilities->get("https://pokeapi.co/api/v2/ability?offset=0&limit=2000")->getBody()->getContents())->results;

        foreach ($Abilities as $Key => $Ability) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;
            $AbilityInfo = json_decode($ClientAbilities->get($Ability->url)->getBody()->getContents());

            $MainData['Ability_Id'] = $AbilityInfo->id;
            $OptionalData['Ability_Name'] = $AbilityInfo->name;
            $OptionalData['Generation'] = $AbilityInfo->generation->name;
            $OptionalData['Ability_Effect'] = null;
            $OptionalData['Ability_Entry'] = null;
            $OptionalData['Ability_Flavor'] = null;
            $OptionalData['Is_Main_Serie'] = $AbilityInfo->is_main_series;

            foreach ($AbilityInfo->effect_changes as $Effect) {
                foreach ($Effect->effect_entries as $text) {
                    if($text->language->name == "en")
                        $OptionalData['Ability_Entry'] = $text->effect;
                }
            }

            foreach ($AbilityInfo->effect_entries as $text) {
                if($text->language->name == "en")
                    $OptionalData['Ability_Effect'] = $text->effect;
            }

            foreach ($AbilityInfo->flavor_text_entries as $text) {
                if($text->language->name == "en")
                    $OptionalData['Ability_Flavor'] = $text->flavor_text;
            }
            
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonAbilities', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info(($Key+1)." ".$AbilityInfo->name." - ".$Msg);            
        }
    }

    //Get All pokemon Moves
    public function GetAllPokemonMoves() {
        $this->info("-- Import Pokemon Moves --");
        $ClientMoves = new Client(['verify' => false]);
        $Moves = json_decode($ClientMoves->get("https://pokeapi.co/api/v2/move/?offset=0&limit=2000")->getBody()->getContents())->results;

        foreach ($Moves as $Key => $Move) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;
            $MoveInfo = json_decode($ClientMoves->get($Move->url)->getBody()->getContents());
           

            $MainData['Move_Id'] = $MoveInfo->id;
            $OptionalData['Move_Name'] = $MoveInfo->name;
            $OptionalData['Generation'] = $MoveInfo->generation->name;
            $OptionalData['Move_Accuracy'] = $MoveInfo->accuracy;
            $OptionalData['Move_Power'] = $MoveInfo->power;
            $OptionalData['Move_PP'] = $MoveInfo->pp;
            $OptionalData['Move_Priority'] = $MoveInfo->priority;
            $OptionalData['Move_Type'] = DB::table('pokemontypes')->where([['Type_Name', $MoveInfo->type->name]])->first()->Type_Id;
            $OptionalData['Move_Target'] = $MoveInfo->target->name;
            $OptionalData['Move_DamageClass'] = $MoveInfo->damage_class->name;
            $OptionalData['Move_Effect'] = null;
            $OptionalData['Move_Flavor'] = null;

            foreach ($MoveInfo->effect_entries as $text) {
                if($text->language->name == "en")
                    $OptionalData['Move_Effect'] = $text->effect;
            }

            foreach ($MoveInfo->flavor_text_entries as $text) {
                if($text->language->name == "en")
                    $OptionalData['Move_Flavor'] = $text->flavor_text;
            }
            
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonMoves', $MainData, $OptionalData, $AlloWUpdate);

            $this->info($MoveInfo->id." ".$MoveInfo->name." - ".$Msg);            
        }
    }

    //Get All pokemon Games
    public function GetAllPokemonGames() {
        $this->info("-- Import Pokemon Games --");
        $ClientGames = new Client(['verify' => false]);
        $Games = json_decode($ClientGames->get("https://pokeapi.co/api/v2/version?offset=0&limit=100")->getBody()->getContents())->results;

        foreach ($Games as $Key => $Game) {
            $MainData = $OptionalData =[];
            $AlloWUpdate = false;
            $GameInfo = json_decode($ClientGames->get($Game->url)->getBody()->getContents());
        

            $MainData['Version_Id'] = $GameInfo->id;
            $OptionalData['Version_Name'] = $GameInfo->name;
            $OptionalData['Version_Group'] = $GameInfo->version_group->name;

            $GroupInfo = json_decode($ClientGames->get($GameInfo->version_group->url)->getBody()->getContents());

            $OptionalData['Generation'] = $GroupInfo->generation->name;

            foreach ($GroupInfo->regions as $Region) {
                $OptionalData[$Region->name] = true;
            }
            
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            $Msg = AddRecord('PokemonVersions', $MainData, $OptionalData, $AlloWUpdate);
            
            $this->info($GameInfo->id." ".$GameInfo->name." - ".$Msg);           
        }
    }

    //Get All pokemon Pokemons
    public function GetAllPokemonList($pageURL) {
        $this->info("-- Import Pokemons --");
        $ClientPokemons = new Client(['verify' => false]);
        $Pokemons = json_decode($ClientPokemons->get($pageURL)->getBody()->getContents());

        foreach ($Pokemons->results as $Key => $Pokemon) {
            $MainData = $OptionalData =[];

            $AlloWUpdate = false;
            $ClientPokemon = new Client(['verify' => false]);
            $PokemonInfo = json_decode($ClientPokemons->get($Pokemon->url)->getBody()->getContents());
            $SpecieInfo = json_decode($ClientPokemons->get($PokemonInfo->species->url)->getBody()->getContents());
            $PokemonId = $PokemonInfo->id;

            $MainData['Pokemon_Id'] = $PokemonId;
            $MainData['Pokemon_Name'] = $PokemonInfo->name;
            $OptionalData['Is_Default'] = $PokemonInfo->is_default;
            $OptionalData['Height'] = $PokemonInfo->height/10;
            $OptionalData['Weight'] = $PokemonInfo->weight/10;
            $OptionalData['Base_Experience'] = $PokemonInfo->base_experience;
            $OptionalData['Base_Happiness'] = $SpecieInfo->base_happiness;
            $OptionalData['Capture_Rate'] = $SpecieInfo->capture_rate;
            $OptionalData['Forms_Switchable'] = $SpecieInfo->forms_switchable;
            $OptionalData['Gender_Rate'] = $SpecieInfo->gender_rate;
            $OptionalData['Gender_Diff'] = $SpecieInfo->has_gender_differences;
            $OptionalData['Hatch_Steps'] = $SpecieInfo->hatch_counter * 128;
            $OptionalData['Is_Baby'] = $SpecieInfo->is_baby;
            $OptionalData['Is_Legendary'] = $SpecieInfo->is_legendary;
            $OptionalData['Is_Mythical'] = $SpecieInfo->is_mythical;
            $OptionalData['Pokemon_Color'] = $SpecieInfo->color->name;
            $OptionalData['Generation'] = $SpecieInfo->generation->name;
            $OptionalData['Growth'] = $SpecieInfo->growth_rate->name;
            $OptionalData['Pre'] = (is_null($SpecieInfo->evolves_from_species)) ? $SpecieInfo->evolves_from_species : DB::table('PokemonSpecies')->where([['Species_Name', $SpecieInfo->evolves_from_species->name]])->first()->Species_Id;
            $OptionalData['Shape'] = (is_null($SpecieInfo->shape)) ? $SpecieInfo->shape : DB::table('PokemonShape')->where([['Shape_Name', $SpecieInfo->shape->name]])->first()->Shape_Id;
            $OptionalData['Back_Default'] = $PokemonInfo->sprites->back_default;
            $OptionalData['Back_Female'] = ($SpecieInfo->has_gender_differences) ? $PokemonInfo->sprites->back_female : $PokemonInfo->sprites->back_default;
            $OptionalData['Back_Shiny_Default'] = $PokemonInfo->sprites->back_shiny;
            $OptionalData['Back_Shiny_Female'] = ($SpecieInfo->has_gender_differences) ? $PokemonInfo->sprites->back_shiny_female : $PokemonInfo->sprites->back_shiny;
            $OptionalData['Front_Default'] = $PokemonInfo->sprites->front_default;
            $OptionalData['Front_Female'] = ($SpecieInfo->has_gender_differences) ? $PokemonInfo->sprites->front_female : $PokemonInfo->sprites->front_default;
            $OptionalData['Front_Shiny_Default'] = $PokemonInfo->sprites->front_shiny;
            $OptionalData['Front_Shiny_Female'] = ($SpecieInfo->has_gender_differences) ? $PokemonInfo->sprites->front_shiny_female : $PokemonInfo->sprites->front_shiny;
            $OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

            foreach ($PokemonInfo->stats as $Stat) {
                if($Stat->stat->name == 'hp'){
                    $OptionalData['HP'] = $Stat->base_stat;
                    $OptionalData['HP_Effort'] = $Stat->effort;
                }

                if($Stat->stat->name == 'attack'){
                    $OptionalData['Attack'] = $Stat->base_stat;
                    $OptionalData['Attack_Effort'] = $Stat->effort;
                }

                if($Stat->stat->name == 'defense'){
                    $OptionalData['Defense'] = $Stat->base_stat;
                    $OptionalData['Defense_Effort'] = $Stat->effort;
                }

                if($Stat->stat->name == 'special-attack'){
                    $OptionalData['Special_Attack'] = $Stat->base_stat;
                    $OptionalData['Special_Attack_Effort'] = $Stat->effort;
                }

                if($Stat->stat->name == 'special-defense'){
                    $OptionalData['Special_Defense'] = $Stat->base_stat;
                    $OptionalData['Special_Defense_Effort'] = $Stat->effort;
                }

                if($Stat->stat->name == 'speed'){
                    $OptionalData['Speed'] = $Stat->base_stat;
                    $OptionalData['Speed_Effort'] = $Stat->effort;
                }
            }

            $Msg = AddRecord('Pokemons', $MainData, $OptionalData, $AlloWUpdate);

            foreach ($SpecieInfo->egg_groups as $EggKey => $Egg) {
                $MainEggData = $OptionalEggData =[];

                $MainEggData['Pokemon_Id'] = $PokemonId;
                $MainEggData['Egg_Id'] = DB::table('PokemonEggs')->where([['Egg_Name', $Egg->name]])->first()->Egg_Id;
                $OptionalEggData['Slot'] = $EggKey+1;
                $OptionalEggData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

                AddRecord('PokemonEggRelation', $MainEggData, $OptionalEggData, $AlloWUpdate);
            }

            foreach ($PokemonInfo->types as $Type) {
                $MainTypeData = $OptionalTypeData =[];

                $MainTypeData['Pokemon_Id'] = $PokemonId;
                $MainTypeData['Type_Id'] = DB::table('PokemonTypes')->where([['Type_Name', $Type->type->name]])->first()->Type_Id;
                $OptionalTypeData['Slot'] = $Type->slot;
                $OptionalTypeData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

                AddRecord('PokemonTypeRelation', $MainTypeData, $OptionalTypeData, $AlloWUpdate);
            }

            foreach ($PokemonInfo->abilities as $Ability) {
                $MainAbilityData = $OptionalAbilityData =[];

                $MainAbilityData['Pokemon_Id'] = $PokemonId;
                $MainAbilityData['Ability_Id'] = DB::table('PokemonAbilities')->where([['Ability_Name', $Ability->ability->name]])->first()->Ability_Id;
                $OptionalAbilityData['Slot'] = $Ability->slot;
                $OptionalAbilityData['Is_Hidden'] = $Ability->is_hidden;
                $OptionalAbilityData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

                AddRecord('PokemonAbilitiesRelation', $MainAbilityData, $OptionalAbilityData, $AlloWUpdate);
            }

            foreach ($PokemonInfo->moves  as $MoveKey => $Move) {
                $MainMoveData = $OptionalMoveData =[];
                
                $MainMoveData['Pokemon_Id'] = $PokemonId;
                $MainMoveData['Move_Key'] = $MoveKey + 1;
                $MainMoveData['Move_Id'] = DB::table('PokemonMoves')->where([['Move_Name', $Move->move->name]])->first()->Move_Id;

                foreach ($Move->version_group_details as $Details) {
                    $OptionalMoveData['Learned_Level'] = $Details->level_learned_at;
                    $OptionalMoveData['Learned_Method'] = $Details->move_learn_method->name;
                    $OptionalMoveData['Learned_In'] = $Details->version_group->name;
                    $OptionalMoveData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

                    AddRecord('PokemonMoveRelation', $MainMoveData, $OptionalMoveData, $AlloWUpdate);
                }
            }

            $this->info($PokemonId." ".$PokemonInfo->name." - ".$Msg);             
        }

        if(!is_null($Pokemons->next))
            $this->GetAllPokemonList($Pokemons->next);
    }
}