<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ImportMTG extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'MTG:Import';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Import Mtg Cards Using MTG API to be used from DB';

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
		//$this->GetAllsets(1);
		//$this->GetFormats(1);
		//$this->GetAllSuperTypes(1);
		//$this->GetAllTypes(1);
		//$this->GetAllSubTypes(1);
		$this->GetAllCards(17);

		$this->info("-- MTG Import completed --");
	}

	//Get All MTG Sets
	public function GetAllsets($Page) {
		if($Page == 1)
			$this->info("-- Import Sets Start --");

		$ClientSets = new Client(['verify' => false]);
		$Sets = json_decode($ClientSets->get("https://api.magicthegathering.io/v1/sets?page=$Page")->getBody()->getContents())->sets;

		if(count($Sets) > 0)
			$this->info("-- Set Page $Page--");

		foreach ($Sets as $Key => $Set) {
			$MainData = $OptionalData =[];
			$AlloWUpdate = false;

			$MainData['Set_Id'] = $Set->code;
			$OptionalData['Set_Name'] = $Set->name;
			$OptionalData['Set_Type'] = $Set->type;
			$OptionalData['Set_Block'] = isset($Set->block) ? $Set->block : '';
			$OptionalData['Set_Online_Only'] = $Set->onlineOnly;
			$OptionalData['Set_Release_Date'] = Carbon::parse($Set->releaseDate)->format('Y-m-d H:i:s');
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			$Msg = AddRecord('MagicSets', $MainData, $OptionalData, $AlloWUpdate);

			$this->info(($Key+1)." ".$Set->code." - ".$Msg);
		}

		if(count($Sets) > 0)
			$this->GetAllsets($Page+1);
		else
			$this->info("-- Import Sets End --");
	}

	//Get All MTG Formats
	public function GetFormats($Page) {
		if($Page == 1)
			$this->info("-- Import Formats Start --");
		
		$ClientSets = new Client(['verify' => false]);
		$Formats = json_decode($ClientSets->get("https://api.magicthegathering.io/v1/formats?page=$Page")->getBody()->getContents())->formats;

		if(count($Formats) > 0)
			$this->info("-- Formats Page $Page--");

		foreach ($Formats as $Key => $Format) {
			$MainData = $OptionalData =[];
			$AlloWUpdate = false;

			$MainData['Format_Id'] = ($Key+1);
			$OptionalData['Format_Name'] = $Format;
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			$Msg = AddRecord('MagicFormats', $MainData, $OptionalData, $AlloWUpdate);

			$this->info(($Key+1)." ".$Format." - ".$Msg);
		}

		if(count($Formats) > 0)
			$this->GetFormats($Page+1);
		else
			$this->info("-- Import Formats End --");
	}

	//Get All MTG Super Types
	public function GetAllSuperTypes($Page) {
		if($Page == 1)
			$this->info("-- Import Super Types Start--");

		$ClientSuperTypes = new Client(['verify' => false]);
		$SuperTypes = json_decode($ClientSuperTypes->get("https://api.magicthegathering.io/v1/supertypes?page=$Page")->getBody()->getContents())->supertypes;

		if(count($SuperTypes) > 0)
			$this->info("-- Super Types Page $Page--");

		foreach ($SuperTypes as $Key => $SuperType) {
			$MainData = $OptionalData =[];
			$AlloWUpdate = false;

			$MainData['Super_Type_Id'] = ($Key+1);
			$OptionalData['Super_Type_Name'] = $SuperType;
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			$Msg = AddRecord('MagicSuperTypes', $MainData, $OptionalData, $AlloWUpdate);

			$this->info(($Key+1)." ".$SuperType." - ".$Msg);
		}

		if(count($SuperTypes) > 0)
			$this->GetAllSuperTypes($Page+1);
		else
			$this->info("-- Import Super Types End --");
	}

	//Get All MTG Types
	public function GetAllTypes($Page) {
		if($Page == 1)
			$this->info("-- Import Types Start --");

		$ClientTypes = new Client(['verify' => false]);
		$Types = json_decode($ClientTypes->get("https://api.magicthegathering.io/v1/types?page=$Page")->getBody()->getContents())->types;

		if(count($Types) > 0)
			$this->info("-- Types Page $Page--");

		foreach ($Types as $Key => $Type) {
			$MainData = $OptionalData =[];
			$AlloWUpdate = false;

			$MainData['Type_Id'] = ($Key+1);
			$OptionalData['Type_Name'] = $Type;
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			if($Type != "Dragon" || $Type != "Elemental" || $Type != "Goblin" || $Type != "Jaguar" || $Type != "Knights" || $Type != "Legend" || $Type != "Wolf")
				$Msg = AddRecord('MagicTypes', $MainData, $OptionalData, $AlloWUpdate);
			
			$this->info(($Key+1)." ".$Type." - ".$Msg);
		}

		if(count($Types) > 0)
			$this->GetAllTypes($Page+1);
		else
			$this->info("-- Import Types End --");
	}

	//Get All MTG Sub Types
	public function GetAllSubTypes($Page) {
		if($Page == 1)
			$this->info("-- Import Sub Types Start--");

		$ClientSubTypes = new Client(['verify' => false]);
		$SubTypes = json_decode($ClientSubTypes->get("https://api.magicthegathering.io/v1/subtypes?page=$Page")->getBody()->getContents())->subtypes;

		if(count($SubTypes) > 0)
			$this->info("-- Sub Types Page $Page--");

		foreach ($SubTypes as $Key => $SubType) {
			$MainData = $OptionalData =[];
			$AlloWUpdate = false;

			$Sub_Type_Id = ($Key+1+(500*$Page)-500);

			$MainData['Sub_Type_Name'] = $SubType;
			$OptionalData['Sub_Type_Id'] = $Sub_Type_Id;
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			$Msg = AddRecord('MagicSubTypes', $MainData, $OptionalData, $AlloWUpdate);
			
			$this->info($Sub_Type_Id." ".$SubType." - ".$Msg);
		}

		if(count($SubTypes) > 0)
			$this->GetAllSubTypes($Page+1);
		else
			$this->info("-- Import Sub Types End--");
	}

	//Get All MTG Sub Types
	public function GetAllCards($Page) {
		if($Page == 1)
			$this->info("-- Import Cards Start--");

		$ClientSubTypes = new Client(['verify' => false]);
		$Cards = json_decode($ClientSubTypes->get("https://api.magicthegathering.io/v1/cards?page=$Page")->getBody()->getContents())->cards;

		if(count($Cards) > 0)
			$this->info("-- Cards Page $Page--");

		foreach ($Cards as $Key => $Card) {
			$MainData = $OptionalData = $MainDataSet = $OptionalDataSet =[];
			$AlloWUpdate = false;

			$Card_Id = DB::table('magiccards')
			->select(DB::raw('ifnull(Card_Id,0) as Card_Id'))
            ->where([['Card_Name', $Card->name]])
            ->union(DB::table('magiccards')->select(DB::raw('ifnull(max(Card_Id),0)+1 as Card_Id')))
            ->first()->Card_Id;

			$MainData['Card_Name'] = $Card->name;
			$OptionalData['Card_Id'] = $Card_Id;
			$OptionalData['Card_Type'] = $Card->type;
			$OptionalData['Card_Rarity'] = $Card->rarity;
			$OptionalData['Card_Layout'] = $Card->layout;
			$OptionalData['Card_CMC'] = $Card->cmc;
			$OptionalData['Card_Text'] = (isset($Card->text)) ? str_replace("\n", '</br>', $Card->text) : '';
			$OptionalData['Card_Mana_Cost'] = (isset($Card->manaCost)) ? $Card->manaCost : 0;
			$OptionalData['Card_Life'] = (isset($Card->life)) ? $Card->life : 0;
			$OptionalData['Card_Loyalty'] = (isset($Card->loyalty)) ? $Card->loyalty : 0;
			$OptionalData['Card_Power'] = (isset($Card->power)) ? $Card->power : 0;
			$OptionalData['Card_Toughness'] = (isset($Card->toughness)) ? $Card->toughness : 0;
			$OptionalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

			$Msg = AddRecord('MagicCards', $MainData, $OptionalData, $AlloWUpdate);

			$MainDataSet['Card_Id'] = $Card_Id;
			$OptionalDataSet['Card_Universal_Id'] = $Card->id;
			$OptionalDataSet['Card_Set_Number'] = $Card->number;
			$OptionalDataSet['Card_Artist'] = (isset($Card->artist)) ? $Card->artist : 0;
			$OptionalDataSet['Card_Image_Url'] = (isset($Card->imageUrl)) ? $Card->imageUrl : 0;
			$OptionalDataSet['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');


            foreach ($Card->printings as $PKey => $print) {
            	$MainDataSet['Set_Id'] = $print;
            	AddRecord('MagicCardsPrints', $MainDataSet, $OptionalDataSet, $AlloWUpdate);
            }

            foreach ($Card->types as $TKey => $Type) {
                $MainTypeData = $OptionalTypeData =[];
                $MainSubTypeData = $OptionalSubTypeData =[];

				if($Type != "Dragon" || $Type != "Elemental" || $Type != "Goblin" || $Type != "Jaguar" || $Type != "Knights" || $Type != "Legend" || $Type != "Wolf") {
					$MainTypeData['Card_Id'] = $Card_Id;
					$MainTypeData['Type_Id'] = DB::table('MagicTypes')->where([['Type_Name', $Type]])->first()->Type_Id;
					$OptionalTypeData['Slot'] = $TKey;
					$OptionalTypeData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicTypeRelation', $MainTypeData, $OptionalTypeData, $AlloWUpdate);
				}
				else {
					$MainSubTypeData['Card_Id'] = $Card_Id;
					$MainSubTypeData['Sub_Type_Id'] = DB::table('MagicSubTypes')->where([['Sub_Type_Name', $Type]])->first()->Sub_Type_Id;
					$OptionalSubTypeData['Slot'] = $TKey;
					$OptionalSubTypeData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicSubTypeRelation', $OptionalSubTypeData, $MainSubTypeData, $AlloWUpdate);
				}
            }

            if(isset($Card->colorIdentity)) {
	            foreach ($Card->colorIdentity as $CKey => $color) {
                	$MainColorIdentityData = $OptionalcColorIdentityData =[];
					$MainColorIdentityData['Card_Id'] = $Card_Id;
					$MainColorIdentityData['Card_Color'] = $color;
					$OptionalcColorIdentityData['Slot'] = $CKey;
					$OptionalcColorIdentityData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicColorIdentity', $MainColorIdentityData, $OptionalcColorIdentityData, $AlloWUpdate);
	            }
            }
            else {
                $MainColorIdentityData = $OptionalcColorIdentityData =[];
				$MainColorIdentityData['Card_Id'] = $Card_Id;
				$MainColorIdentityData['Card_Color'] = 'C';
				$OptionalcColorIdentityData['Slot'] = 1;
				$OptionalcColorIdentityData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

				AddRecord('MagicColorIdentity', $MainColorIdentityData, $OptionalcColorIdentityData, $AlloWUpdate);
            }

            if(isset($Card->colors)) {
	            foreach ($Card->colors as $CKey => $color) {
                	$MainColorData = $OptionalcColorData =[];
					$MainColorData['Card_Id'] = $Card_Id;
					$MainColorData['Card_Color'] = $color;
					$OptionalcColorData['Slot'] = $CKey;
					$OptionalcColorData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicColor', $MainColorData, $OptionalcColorData, $AlloWUpdate);
	            }
            }
            else {
                $MainColorData = $OptionalcColorData =[];
				$MainColorData['Card_Id'] = $Card_Id;
				$MainColorData['Card_Color'] = 'C';
				$OptionalcColorData['Slot'] = 1;
				$OptionalcColorData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

				AddRecord('MagicColor', $MainColorData, $OptionalcColorData, $AlloWUpdate);
            }

            if(isset($Card->legalities)) {
	            foreach ($Card->legalities as $LKey => $legal) {
                	$MainLegalData = $OptionalLegalData =[];

					$MainLegalData['Card_Id'] = $Card_Id;
					$MainLegalData['Format_Id'] = DB::table('MagicFormats')->where([['Format_Name', $legal->format]])->first()->Format_Id;
					$OptionalLegalData['Slot'] = $LKey;
					$OptionalLegalData['Format_Legality'] = $legal->legality;
					$OptionalLegalData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicCardLegalities', $MainLegalData, $OptionalLegalData, $AlloWUpdate);
	            }
            }

            if(isset($Card->rulings)) {
	            foreach ($Card->rulings as $RKey => $Rule) {
                	$MainRuleData = $OptionalRuleData =[];

					$MainRuleData['Card_Id'] = $Card_Id;
					$MainRuleData['Ruling_Date'] = Carbon::parse($Rule->date)->format('Y-m-d H:i:s');
					$OptionalRuleData['Ruling_Text'] = $Rule->text;
					$OptionalRuleData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicRulings', $MainRuleData, $OptionalRuleData, $AlloWUpdate);
	            }
            }

            if(isset($Card->supertypes)) {
	            foreach ($Card->supertypes as $SBKey => $SuperType) {
                	$MainSuperTypesData = $OptionalSuperTypesData =[];

					$MainSuperTypesData['Card_Id'] = $Card_Id;
					$MainSuperTypesData['Super_Type_Id'] = DB::table('MagicSuperTypes')->where([['Super_Type_Name', $SuperType]])->first()->Super_Type_Id;
					$OptionalSuperTypesData['Slot'] = $SBKey;
					$OptionalSuperTypesData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicSuperTypeRelation', $MainSuperTypesData, $OptionalSuperTypesData, $AlloWUpdate);
	            }
            }

            if(isset($Card->subtypes)) {
	            foreach ($Card->subtypes as $SBKey => $SubType) {
                	$MainSubData = $OptionalSubData =[];

					$MainSubData['Card_Id'] = $Card_Id;
					$MainSubData['Sub_Type_Id'] = DB::table('MagicSubTypes')->where([['Sub_Type_Name', $SubType]])->first()->Sub_Type_Id;
					$OptionalSubData['Slot'] = $SBKey;
					$OptionalSubData['Created_Date'] = Carbon::now()->format('Y-m-d H:i:s');

					AddRecord('MagicSubTypeRelation', $MainSubData, $OptionalSubData, $AlloWUpdate);
	            }
            }

			$this->info($Card_Id." ".$Card->set." ".$Card->name." - ".$Msg);
		}

		if(count($Cards) > 0)
			$this->GetAllCards($Page+1);
		else
			$this->info("-- Import Cards End--");
	}
}