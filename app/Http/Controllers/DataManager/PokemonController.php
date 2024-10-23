<?php

namespace App\Http\Controllers\DataManager;

use App\Http\Controllers\Controller;
use App\Helpers\EntityTable\EntityDataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class PokemonController extends Controller {
	protected $Page = 'Pokemon';
	protected 
		$AttSetup = [
			'General' => [
				'HeaderName' => ['Generation', 'Types', 'Abilities', 'Egg Group', 'Growth', 'Is Legendary', 'Is Mythical', 'Is Baby', 'Capture Rate'],
				'Value' => ['Generation', 'Types', 'Abilities', 'EggGroup', 'Growth', 'Is_Legendary', 'Is_Mythical', 'IsBaby', 'CaptureRate'],
				'DisplayBlock' => [],
				'Legend' => [],
				'HTML' => ['Types','Abilities'] ,
				'Bool' => ['Is_Legendary', 'Is_Mythical', 'IsBaby', 'CaptureRate']
			],
			'Sizes' => [
				'HeaderName' => ['Height', 'Weight', 'Shape'],
				'Value' => ['Height', 'Weight', 'Shape'],
				'DisplayBlock' => [],
				'Legend' => [],
				'HTML' => [] ,
				'Bool' => []
			],
			'Shapes' => [
				'HeaderName' => ['Shape', 'Forms Switchable', 'Base Form',  'Color', 'Gender Diff', 'Hatch Steps'],
				'Value' => ['Shape', 'Forms_Switchable', 'Is_Default', 'Pokemon_Color','Gender_Diff','HatchSteps'],
				'DisplayBlock' => [],
				'Legend' => [],
				'HTML' => [] ,
				'Bool' => ['Forms_Switchable', 'Is_Default','Gender_Diff']
			],
			'Combat' => [
				'HeaderName' => ['Base Experience', 'Base Happiness', 'HP', 'Attack', 'Defense', 'Special Attack', 'Special Defense', 'Speed'],
				'Value' => ['Base_Experience', 'Base_Happiness', 'HP', 'Attack', 'Defense', 'Special_Attack', 'Special_Defense', 'Speed'],
				'DisplayBlock' => [],
				'Legend' => [ '', '', 'HP_Effort', 'Attack_Effort', 'Defense_Effort', 'Special_Attack_Effort', 'Special_Defense_Effort', 'Speed_Effort'],
				'HTML' => [],
				'Bool' => []
			]
		];


	public function index(Request $r) {
		$Title = 'Pokemon';

		return view('DataViews.EntityView', $this->mergeTableOptions($this->Page,[
			'Title' => $Title,
			'Page' => $this->Page,
			'TableID' => 'Species_Id'
		]));
	}

	public function GetPokemons(Request $r) {
		$EDH = new EntityDataHelper(
			$r->input('length'),
			$r->input('start'),
			$r->input('draw'),
			$r->input('columns'),
			$r->input('order'),
			$r->input('search'),
			$r->input('filters')
		);

		return $EDH->getPokemonData();
	}

	public function GetPokemonInfo(Request $r,$PokemonNumber) {
		$PokemonData = DB::table('VW_PokemonData')
						->select(
							'VW_PokemonData.*',
							'Base_Experience', 'Base_Happiness', 'HP', 'Attack', 'Defense', 'Special_Attack', 'Special_Defense', 'Speed',
							'HP_Effort', 'Attack_Effort', 'Defense_Effort', 'Special_Attack_Effort', 'Special_Defense_Effort', 'Speed_Effort',
							'Back_Default', 'Front_Default', 'Back_Female', 'Front_Female', 'Back_Shiny_Default', 'Front_Shiny_Default', 'Back_Shiny_Female', 'Front_Shiny_Female','Shape')
						->join('Pokemons', 'Pokemons.Pokemon_Id', '=', 'VW_PokemonData.Species_Id')
						->where('Species_Id', $PokemonNumber)
						->first();


		$Pokemon_Type = $PokemonData->Pokemon_Type;

		$PokemonData->ShapeForm = (!is_null($PokemonData->Shape)) ? DB::table('PokemonShape')->where('Shape_Id', $PokemonData->Shape)->first()->Shape_Name : '';

		$PokemonTypes = DB::table('PokemonTypeRelation')
						->select('Type_Name')
						->join('PokemonTypes', 'PokemonTypes.Type_Id', '=', 'PokemonTypeRelation.Type_Id')
						->where('PokemonTypeRelation.Pokemon_Id', $PokemonNumber)->get();

		$PokemonData->Types = '';
		foreach ($PokemonTypes as $PokemonType){ 
			$PokemonData->Types .= '<span class="badge type-'.$PokemonType->Type_Name.'">'.$PokemonType->Type_Name.'</span> ';
		}

		$EggGroups = DB::table('PokemonEggRelation')
						->select('Egg_Name')
						->join('PokemonEggs', 'PokemonEggs.Egg_Id', '=', 'PokemonEggRelation.Egg_Id')
						->where('PokemonEggRelation.Pokemon_Id', $PokemonNumber)->get();

		$PokemonData->Eggs = '';
		foreach ($EggGroups as $EggGroup){ 
			$PokemonData->Eggs .= '<span class="badge type-normal">'.$EggGroup->Egg_Name.'</span> ';
		}

		$abilities = DB::table('PokemonAbilitiesRelation')
						->select('PokemonAbilities.Ability_Name','PokemonAbilitiesRelation.Slot','PokemonAbilitiesRelation.Is_Hidden')
						->join('PokemonAbilities', 'PokemonAbilities.Ability_Id', '=', 'PokemonAbilitiesRelation.Ability_Id')
						->where('PokemonAbilitiesRelation.Pokemon_Id', $PokemonNumber)->get();

		$PokemonData->Abilities = '';
		foreach ($abilities as $Ability){
			if ($Ability->Is_Hidden == 1) {
				$PokemonData->Abilities .= '<span class="badge type-dark">'.$Ability->Ability_Name.'</span> ';
			}
			else {
				$PokemonData->Abilities .= '<span class="badge type-normal">'.$Ability->Ability_Name.'</span> ';
			}
		}

		$Moves = DB::table('PokemonMoveRelation')
						->select(
							'PokemonMoveRelation.Move_Id',
							'PokemonMoves.Move_Name',
							'PokemonMoveRelation.Move_Key',
							'PokemonMoveRelation.Learned_Level',
							'PokemonMoveRelation.Learned_Method',
							'PokemonMoveRelation.Learned_In',
							'PokemonMoves.Generation',
							'PokemonMoves.Move_Accuracy',
							'PokemonMoves.Move_Power',
							'PokemonMoves.Move_PP',
							'PokemonMoves.Move_Priority',
							'PokemonTypes.Type_Name AS Type',
							'PokemonMoves.Move_Target',
							'PokemonMoves.Move_DamageClass',
							'PokemonMoves.Move_Effect'
						)
						->join('PokemonMoves', 'PokemonMoves.Move_Id', '=', 'PokemonMoveRelation.Move_Id')
						->join('PokemonTypes', 'PokemonTypes.Type_Id', '=', 'PokemonMoves.Move_Type')
						->where('PokemonMoveRelation.Pokemon_Id', $PokemonNumber)->get();

		$Sets = (object) [];

		$Sets->Headers = (object) ['','Move Name', 'Learning method', 'Gen', 'Accuracy', 'Power', 'PP', 'Priority', 'Target', 'DamageClass'];

		foreach ($Moves as $Move) {
			$Sets->Items[] = [
				$Move->Move_Key,
				'<span class="btn badge type-'.$Move->Type.'" data-toggle="tooltip" data-placement="top" title="'.$Move->Move_Effect.'">'.$Move->Move_Name.'</span>',
				(($Move->Learned_Method == 'level-up') ? $Move->Learned_Level : $Move->Learned_Method),
				$Move->Generation,
				$Move->Move_Accuracy,
				$Move->Move_Power,
				$Move->Move_PP,
				$Move->Move_Priority,
				$Move->Move_Target,
				$Move->Move_DamageClass
			];
		}

		$Title = $PokemonData->Pokemon_Name;

		$Images = (object) [
			'Tabs' => [],
			'Images' => []
		];

		//Set Images
		if(!is_null($PokemonData->Back_Default) || !is_null($PokemonData->Front_Default)) {
			$Images->Tabs[] = 'Default';
			$Images->Images['Default'] = [];

			if(!is_null($PokemonData->Back_Default))
				$Images->Images['Default'][] = $PokemonData->Back_Default;
			if(!is_null($PokemonData->Front_Default))
				$Images->Images['Default'][] = $PokemonData->Front_Default;
		}

		if(!is_null($PokemonData->Back_Female) || !is_null($PokemonData->Front_Female)) {
			$Images->Tabs[] = 'Female';
			$Images->Images['Female'] = [];

			if(!is_null($PokemonData->Back_Female))
				$Images->Images['Female'][] = $PokemonData->Back_Female;
			if(!is_null($PokemonData->Front_Female))
				$Images->Images['Female'][] = $PokemonData->Front_Female;
		}

		if(!is_null($PokemonData->Back_Shiny_Default) || !is_null($PokemonData->Front_Shiny_Default)) {
			$Images->Tabs[] = 'Shiny_Default';
			$Images->Images['Shiny_Default'] = [];

			if(!is_null($PokemonData->Back_Shiny_Default))
				$Images->Images['Shiny_Default'][] = $PokemonData->Back_Shiny_Default;
			if(!is_null($PokemonData->Front_Shiny_Default))
				$Images->Images['Shiny_Default'][] = $PokemonData->Front_Shiny_Default;
		}

		if(!is_null($PokemonData->Back_Shiny_Female) || !is_null($PokemonData->Front_Shiny_Female)) {
			$Images->Tabs[] = 'Shiny_Female';
			$Images->Images['Shiny_Female'] = [];

			if(!is_null($PokemonData->Back_Shiny_Female))
				$Images->Images['Shiny_Female'][] = $PokemonData->Back_Shiny_Female;
			if(!is_null($PokemonData->Front_Shiny_Female))
				$Images->Images['Shiny_Female'][] = $PokemonData->Front_Shiny_Female;
		}

		$Attributes = $this->SetAttributes($this->AttSetup,$PokemonData);

		$Data = $this->MergeData($PokemonData->Pokemon_Name,$Images,$Attributes,$Pokemon_Type,$Sets);

		return view('Details.Details', $this->mergeDetailsOptions($this->Page,[
			'Title' => $Title,
			'Data' => $Data
		]));

	}
}
