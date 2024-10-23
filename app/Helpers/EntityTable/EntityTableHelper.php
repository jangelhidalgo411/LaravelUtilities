<?php

namespace App\Helpers\EntityTable;

use Illuminate\Support\Facades\DB;

class EntityTableHelper {
	public function __construct($Table) {
		$this->Table = $Table;
	}

	public function getHeaders() {
		switch ($this->Table) {
			case 'Pokemon':
				return [
					'Species',
					'Nº',
					'Name',
					'Color',
					'Gen',
					'Growth Type',
					'Type',
					'Legend',
					'Myth',
					'Height (M)',
					'Weight (Kg)',
					''
				];
				break;
			case 'MTG':
				return [
					'Nº',
					'Name',
					'Rarity',
					'CMC',
					'Mana Cost',
					'Card Type',
					'Life',
					'Loyalty',
					'Power',
					'Toughness',
					'prints',
					''
				];
				break;
		}
	}

	public function getFilters() {
		$Filters = [];

		switch ($this->Table) {
			case 'Pokemon':
				$Filters =  [
					'Type' => [
						'FilterCaption'	=> 'Pokemon Type',
						'Options' => GetOptions('PokemonTypes', 'Type_Id', 'Type_Name', 'Type_Name')
					],
					'Pokemon_Color' => [
						'FilterCaption'	=> 'Color',
						'Options' => GetOptions('Pokemons', 'Pokemon_Color', 'Pokemon_Color', 'Pokemon_Color')
					],
					'Generation' => [
						'FilterCaption'	=> 'Generation',
						'Options' => GetOptions('VW_Generation', 'Generation', 'Generation', '')
					],
					'Growth' => [
						'FilterCaption'	=> 'Growth Type',
						'Options' => GetOptions('Pokemons', 'Growth', 'Growth', 'Growth')
					],
					'Gender_Diff' => [
						'FilterCaption'	=> 'Has Gender Difference',
						'Options' => BooleanOptions()
					],
					'Is_Legendary' => [
						'FilterCaption'	=> 'Is Legendary',
						'Options' => BooleanOptions()
					],
					'Is_Mythical' => [
						'FilterCaption'	=> 'Is Mythical',
						'Options' => BooleanOptions()
					],
				];
				break;
			case 'MTG':
				$Filters =  [
					'Formats' => [
						'FilterCaption'	=> 'Pokemon Type',
						'Options' => GetOptions('magicformats', 'Format_Id', 'Format_Name', 'Format_Name')
					],
					'Sets' => [
						'FilterCaption'	=> 'Sets',
						'Options' => GetOptions('magicsets', 'Set_Id', 'Set_Name', 'Set_Release_Date')
					],
					'Color' => [
						'FilterCaption'	=> 'Card Color',
						'Options' => MTGCardOptions()
					],
					'ColorIdentity' => [
						'FilterCaption'	=> 'Card Color Identity',
						'Options' => MTGCardOptions()
					],
					'SuperTypes' => [
						'FilterCaption'	=> 'Super Type',
						'Options' => GetOptions('magicsupertypes', 'Super_Type_Id', 'Super_Type_Name', 'Super_Type_Name')
					],
					'Types' => [
						'FilterCaption'	=> 'Type',
						'Options' => GetOptions('magictypes', 'Type_Id', 'Type_Name', 'Type_Name')
					],
					'SubTypes' => [
						'FilterCaption'	=> 'Sub Type',
						'Options' => GetOptions('magicsubtypes', 'Sub_Type_Id', 'Sub_Type_Name', 'Sub_Type_Name')
					],
				];
				break;
		}

		return $Filters;
	}

	public function getCustomCSS() {
		$CustomCSS = '';
		switch ($this->Table) {
			case 'Pokemon':
				$CustomCSS = 'pokemon';
				break;
			case 'MTG':
				$CustomCSS = 'MTG';
				break;
		}

		return $CustomCSS;
	}

	public function getDataURL() {
		$DataURL = '';

		switch ($this->Table) {
			case 'Pokemon':
				$DataURL = '/Getpokemons';
				break;
			case 'MTG':
				$DataURL = '/Getcards';
				break;
		}

		return $DataURL;
	}
}