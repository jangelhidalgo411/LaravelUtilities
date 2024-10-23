<?php

namespace App\Helpers\EntityTable;

class EntityColumnHelper {
	public function __construct($Table) {
		$this->Table = $Table;
	}

	public function getColumns() {
		$Columns = [];

		switch ($this->Table) {
			case 'Pokemon':
				$Columns =  [
					[
						'data'				=> 'Species',
						'orderable'			=> true,
						'width'				=> '10%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Species_Id',
						'orderable'			=> true,
						'width'				=> '5%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Pokemon_Name',
						'orderable'			=> true,
						'width'				=> '15%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Pokemon_Color',
						'orderable'			=> true,
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Generation',
						'orderable'			=> false,
						'formater' => function( $d, $row ) {
							return $d.$row;
						}
					],
					[
						'data'				=> 'Growth',
						'orderable'			=> false,
						'width'				=> '15%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Pokemon_Type',
						'orderable'			=> false,
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Is_Legendary',
						'orderable'			=> false,
						'width'				=> '5%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Is_Mythical',
						'orderable'			=> false,
						'width'				=> '5%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Height',
						'orderable'			=> true,
						'width'				=> '5%',
						'defaultContent'	=> ''
					],
					[
						'data'				=> 'Weight',
						'orderable'			=> true,
						'width'				=> '5%',
						'defaultContent'	=> ''
					]
				];
				break;
			case 'MTG':
				$Columns =  [
					[
						'data' => 'Card_Id',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Name',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Rarity',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_CMC',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Mana_Cost',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Type',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Life',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Loyalty',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Power',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'Card_Toughness',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					],
					[
						'data' => 'prints',
						'orderable' => true,
						'width' => '10%',
						'defaultContent'=> ''
					]
				];
				break;

		}

		return $Columns; 
	}
}