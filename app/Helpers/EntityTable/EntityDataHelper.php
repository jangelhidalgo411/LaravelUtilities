<?php

namespace App\Helpers\EntityTable;
use Illuminate\Support\Facades\DB;
use App\Models\MagicCardLegalities;
use App\Models\MagicCardsPrints;
use App\Models\MagicColor;
use App\Models\MagicColorIdentity;
use App\Models\MagicSuperTypeRelation;
use App\Models\MagicTypeRelation;
use App\Models\MagicSubTypeRelation;

class EntityDataHelper {
	public function __construct($Limit,$Offset,$Draw,$Columns,$Order,$Search,$Filters) {
		$this->Limit 	= $Limit;
		$this->Offset 	= $Offset;
		$this->Draw 	= $Draw;
		$this->Columns 	= $Columns;
		$this->Order 	= $Order;
		$this->Search 	= $Search;
		$this->Filters 	= $Filters;
	}

	/**
	 *  Get data from ajax post - Pokemons
	 *
	 *  @return  Array		   Data to be returned to ajax
	 */
	public function getPokemonData() {
		$preSelectedDemos = [
			'Species_Id', 'Pokemon_Id', 'Pokemon_Name', 'Pokemon_Color', 'Generation', 'Growth', 'Pokemon_Type', 'Is_Legendary', 'Is_Mythical', 'Height', 'Weight'
		];

		$Offset = (!is_null($this->Offset)) ? $this->Offset : 0;
		$Limit = (!is_null($this->Limit)) ? $this->Limit : 10;

		$Data = $DataFiltered = DB::table('VW_PokemonData');

		if(!is_null($this->Filters))
			foreach($this->Filters as $KFilter => $Filter) {
				if($KFilter == 'Type')
					$DataFiltered->whereIn('Species_Id', DB::table('PokemonTypeRelation')->select('Pokemon_Id')->whereIn('Type_Id', $Filter));
				else
					$DataFiltered->whereIn($KFilter, $Filter);
			}


		if(isset($this->Search['value']))
			$DataFiltered->where('Pokemon_Name', 'like', '%'.$this->Search['value'].'%');

		if(!is_null($this->Order))
			foreach($this->Order as $Order) {
				$DataFiltered->orderBy($preSelectedDemos[$Order['column']], $Order['dir']);
			}

		$RecordsTotal = count($Data->get());
		$recordsFiltered = count($DataFiltered->get());
		$Data = $DataFiltered->offset($Offset)->limit($Limit)->get();

		return [
			'data' => $Data,
			'draw' => intval($this->Draw),  
			'recordsTotal' => $RecordsTotal,  
			'recordsFiltered' => $recordsFiltered
		];
	}

	/**
	 *  Get data from ajax post - MTG
	 *
	 *  @return  Array		   Data to be returned to ajax
	 */
	public function GetCardData() {
		$preSelectedDemos = [
			'Card_Id', 'Card_Name', 'Card_Rarity', 'Card_CMC', 'Card_Type', 'Card_Mana_Cost', 'Card_Life', 'Card_Loyalty', 'Card_Power', 'Card_Toughness', 'prints'
		];

		$Offset = (!is_null($this->Offset)) ? $this->Offset : 0;
		$Limit = (!is_null($this->Limit)) ? $this->Limit : 10;

		$Data = $DataFiltered = DB::table('MagicCards');

		if(!is_null($this->Filters))
			foreach($this->Filters as $KFilter => $Filter) {
				if($KFilter == 'Formats')
					$DataFiltered->whereIn('Card_Id', MagicCardLegalities::select('Card_Id')->whereIn('Format_Id', $Filter));
				if($KFilter == 'Sets')
					$DataFiltered->whereIn('Card_Id', MagicCardsPrints::select('Card_Id')->whereIn('Set_Id', $Filter));
				if($KFilter == 'Color')
					$DataFiltered->whereIn('Card_Id', MagicColor::select('Card_Id')->whereIn('Card_Color', $Filter));
				if($KFilter == 'ColorIdentity')
					$DataFiltered->whereIn('Card_Id', MagicColorIdentity::select('Card_Id')->whereIn('Card_Color', $Filter));
				if($KFilter == 'SuperTypes')
					$DataFiltered->whereIn('Card_Id', MagicSuperTypeRelation::select('Card_Id')->whereIn('Super_Type_Id', $Filter));
				if($KFilter == 'Types')
					$DataFiltered->whereIn('Card_Id', MagicTypeRelation::select('Card_Id')->whereIn('Type_Id', $Filter));
				if($KFilter == 'SubTypes')
					$DataFiltered->whereIn('Card_Id', MagicSubTypeRelation::select('Card_Id')->whereIn('Sub_Type_Id', $Filter));
			}

		if(isset($this->Search['value']))
			$DataFiltered->where('Card_Name', 'like', '%'.$this->Search['value'].'%');

		if(!is_null($this->Order))
			foreach($this->Order as $Order) {
				$DataFiltered->orderBy($preSelectedDemos[$Order['column']], $Order['dir']);
			}

		$RecordsTotal = count($Data->get());
		$recordsFiltered = count($DataFiltered->get());
		$Data = $DataFiltered->offset($Offset)->limit($Limit)->get();

		return [
			'data' => $Data,
			'draw' => intval($this->Draw),  
			'recordsTotal' => $RecordsTotal,  
			'recordsFiltered' => $recordsFiltered
		];
	}
}