<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class PokemonController extends Controller {
    protected $DefaultPerPage = 100000;
    protected $DefaultExclude = 0;
    protected $PokemonSprite = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/XXXXX.png';
    protected $PokemonShinySprite = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/XXXXX.png';

    protected $PokemonTableInfo = '<table class="col-12 table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="2">
                    <div class="row m-0">
                        [front_default][front_shiny][back_default][back_shiny][front_female][front_shiny_female][back_female][back_shiny_female]
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Number</th>
                <td>[PokemonNumber]</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>[PokemonName]</td>
            </tr>
            <tr>
                <th>Types</th>
                <td>[PokemonTypes]</td>
            </tr>
            <tr>
                <th>Height</th>
                <td>[PokemonHeight] m</td>
            </tr>
            <tr>
                <th>Weight</th>
                <td>[PokemonWeight] Kg</td>
            </tr>
            <tr>
                <th class="bg-warning" colspan="2">Abilities</th>
            </tr>
            <tr>
                <th>Name</th>
                <th>Description</th>
            </tr>

            [PokemonAbility]
            <tr>
                <th class="bg-warning" colspan="2">Stats</th>
            </tr>
            [PokemonStats]
        </tbody>
    </table>';

    protected $Type = '<span class="PokemonSpan [PokemonType]">[PokemonType]</span>';
    protected $Ability = '<tr><td>[PokemonAbilities] [HiddenAbilities]</td><td>[AbilitiesDescription]</td></tr>';
    protected $Stat = '<tr><th>[StatName]</th><td class="row m-0"><label for="[StatName]" class="col-2 col-form-label">[StatPoints]</label><div class="col-10"><input type="range" class="form-control stat-[StatPoints]" id="[StatName]" min="0" max="255" value="[StatPoints]" /></div></td>';
    protected $Img = '<div class="col"><div class="text-center"><img class="rounded" src="[image]" alt="[name]"><h5 class="col-12">[FrontSide]</h5></div></div>';

    public function index(Request $r) {
        $Title = 'Pokemon';

        return view('DataViews.EntityView', $this->mergeOptions('pokemon',[
            'Title' => $Title
        ]));
    }

    public function GetPokemons(Request $r) {
        $AmountPerPage = $r->AmountPerPage;
        $ExcludeFirst = $r->ExcludeFirst;

        return $this->FormatPokemon($AmountPerPage, $ExcludeFirst);
    }

    public function GetPokemonInfo($PokemonNumber,Request $r) {
        $Client = new Client(['verify' => false]);
        $PokemonInfo = json_decode($Client->get("https://pokeapi.co/api/v2/pokemon/$PokemonNumber/")->getBody()->getContents());
        $PokemonImages = $PokemonTypes = $PokemonAbility = $PokemonStats = '';

        $Pokemon = [
            'Id' => $PokemonInfo->id,
            'Name' => $PokemonInfo->name,
            'Height' => $PokemonInfo->height/10,
            'Weight' => $PokemonInfo->weight/10,
            'Types' => $PokemonInfo->types,
            'Abilities' => $PokemonInfo->abilities,
            'Stats' => $PokemonInfo->stats,
            //'Moves' => $PokemonInfo->moves
        ];

        foreach($Pokemon['Types'] as $Index => $Type) {
            $PokemonTypes .= str_replace('[PokemonType]', $Type->type->name, $this->Type);
        }

        foreach($Pokemon['Stats'] as $Index => $Stat) {
            $PokemonStats .= str_replace(['[StatName]','[StatPoints]'], [$Stat->stat->name, $Stat->base_stat], $this->Stat);
        }

        foreach($PokemonInfo->sprites as $Index => $sprite) {
            $FrontSide = '';

            if($Index == 'front_default')
                $FrontSide = 'Front';
            elseif($Index == 'front_shiny')
                $FrontSide = 'Front Shiny';
            elseif($Index == 'back_default')
                $FrontSide = 'Back';
            elseif($Index == 'back_shiny')
                $FrontSide = 'Back Shiny';
            elseif($Index == 'front_female')
                $FrontSide = 'Front Female';
            elseif($Index == 'front_shiny_female')
                $FrontSide = 'Front Female Shiny';
            elseif($Index == 'back_female')
                $FrontSide = 'Back Female';
            elseif($Index == 'back_shiny_female')
                $FrontSide = 'Back Female Shiny';

            if(in_array($Index, ['front_default', 'front_shiny', 'back_default', 'back_shiny', 'front_female', 'front_shiny_female', 'back_female', 'back_shiny_female'])) {
                if(empty($sprite))
                    $this->PokemonTableInfo = str_replace('['.$Index.']', '', $this->PokemonTableInfo);
                else
                    $this->PokemonTableInfo = str_replace('['.$Index.']', str_replace(['[image]','[FrontSide]','[name]'], [$sprite, $FrontSide, $Pokemon['Name']], $this->Img), $this->PokemonTableInfo);                
            }
        }

        foreach($Pokemon['Abilities'] as $Index => $Ability) {
            $PokemonAbility = str_replace('[PokemonAbilities]', $Ability->ability->name, $this->Ability);
            $PokemonAbility = str_replace('[HiddenAbilities]', ($Ability->is_hidden) ? '(Hidden)' : '', $PokemonAbility);

            $GetAbility = json_decode($Client->get($Ability->ability->url)->getBody()->getContents())->effect_entries;
            $Description = '';
            
            foreach($GetAbility as $AIndex => $effect) {
                if($effect->language->name == 'en')
                    $Description .= $effect->effect.'';
            }

            $PokemonAbility = str_replace('[AbilitiesDescription]', $Description, $PokemonAbility);
        }

        $this->PokemonTableInfo = str_replace(
            ['[PokemonName]', '[PokemonNumber]', '[PokemonHeight]', '[PokemonWeight]', '[PokemonTypes]', '[PokemonAbility]', '[PokemonStats]'],
            [$Pokemon['Name'], $Pokemon['Id'], $Pokemon['Height'], $Pokemon['Weight'], $PokemonTypes, $PokemonAbility, $PokemonStats],
            $this->PokemonTableInfo
        );

        //$GetMove = json_decode($Client->get("https://pokeapi.co/api/v2/move/1/")->getBody()->getContents());

        return $this->PokemonTableInfo;
    }

    private function FormatPokemon($AmountPerPage, $ExcludeFirst) {
        $Client = new Client(['verify' => false]);
        $Limit = (is_int($AmountPerPage)) ? $AmountPerPage : $this->DefaultPerPage; 
        $Offset = (is_int($ExcludeFirst)) ? $ExcludeFirst : $this->DefaultExclude; 

        $Getinfo = json_decode($Client->get("https://pokeapi.co/api/v2/pokemon?offset=$Offset&limit=$Limit")->getBody()->getContents());

        $Pokemons = $Getinfo->results;

        foreach($Pokemons as $Index => $Pokemon) {
            $Pokemon->normal = '<img src="'.$this->GetValue(substr($Pokemon->url, 34, -1), 'normal').'" alt="'.$Pokemon->name.' sprite">';
            $Pokemon->shiny = '<img src="'.$this->GetValue(substr($Pokemon->url, 34, -1), 'shiny').'" alt="'.$Pokemon->name.' sprite">';
            $Pokemon->number = $this->GetValue(substr($Pokemon->url, 34, -1), 'number');
            $Pokemon->action = '<button type="button" class="btn btn-light" onclick="ShowInfo(\''.$Pokemon->name.'\',\'/GetPokemonInfo/'.$Pokemon->name.'\')">ver</button>';
        }

        return [
            'data' => $Pokemons,
            'draw' => 0,
            'recordsTotal' => $Getinfo->count,
            'recordFitered' => $Getinfo->count
        ];
    }

    private function GetValue($Number, $Type) {
        if($Type == 'shiny')
            $Value = str_replace('XXXXX', $Number, $this->PokemonShinySprite);
        elseif($Type == 'number')
            $Value = $Number;
        else
            $Value = str_replace('XXXXX', $Number, $this->PokemonSprite);

        return $Value;
    }
}
