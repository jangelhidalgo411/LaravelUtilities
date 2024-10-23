<?php

namespace App\Http\Controllers\DataManager;

use App\Http\Controllers\Controller;
use App\Helpers\EntityTable\EntityDataHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\MagicCards;
use App\Models\MagicCardsPrints;

class MtgController extends Controller {
	protected $Page = 'MTG';
	protected $AttSetup = [
		'General' => [
			'HeaderName' => ['Name', 'Type', 'Rarity', 'Mana Cost', 'Card_CMC', 'Effect', 'Loyalty', 'Life', 'Power/Toughness'],
			'Value' => ['Card_Name', 'Card_Type', 'Card_Rarity', 'Card_Mana_Cost', 'Card_CMC', 'Card_Text', 'Card_Loyalty', 'Card_Life', 'Card_Power_Toughness'],
			'DisplayBlock' => ['Card_Text'],
			'Legend' => [],
			'HTML' => ['text'] ,
			'Bool' => []
		],
		'Identity' => [
			'HeaderName' => ['Layout', 'Color', 'Color Identity'],
			'Value' => ['Card_Layout', 'Card_Color', 'Card_Identity'],
			'DisplayBlock' => [],
			'Legend' => [],
			'HTML' => [] ,
			'Bool' => []
		]
	];


	public function index(Request $r) {
		$Title = 'MTG';

		return view('DataViews.EntityView', $this->mergeTableOptions($this->Page,[
			'Title' => $Title,
			'Page' => $this->Page,
			'TableID' => 'Card_Name'
		]));
	}

	public function Getcards(Request $r) {
		$EDH = new EntityDataHelper(
			$r->input('length'),
			$r->input('start'),
			$r->input('draw'),
			$r->input('columns'),
			$r->input('order'),
			$r->input('search'),
			$r->input('filters')
		);

		return $EDH->GetCardData();
	}

	public function GetCardInfo(Request $r,$CardName) {
		$MTGData = MagicCards::where('Card_Name', $CardName)->first();

		$Title = $MTGData->Card_Name;

		$MTGData->Card_Power_Toughness = $MTGData->Card_Power."/".$MTGData->Card_Toughness;







		$Images = (object) [
			'Tabs' => [],
			'Images' => []
		];

		$Prints = MagicCardsPrints::where('Card_Id', $MTGData->Card_Id)->first();

		$Images->Tabs[] = '';
		$Images->Images[$Prints->Set_Id] = [];
		$Images->Images[$Prints->Set_Id][] = $Prints->Card_Image_Url;

		$Attributes = $this->SetAttributes($this->AttSetup,$MTGData);

		$Sets = (object) [];

		$Sets->Headers = (object) ['Edition Code', 'Edition Name', 'Set_Release_Date'];

		$MTGSets = DB::table('MagicSets')
					->whereIn('Set_Id',MagicCardsPrints::where('Card_Id', $MTGData->Card_Id)->select('Set_Id')->get())
					->orderBy('Set_Release_Date', 'asc')
					->get();

		foreach ($MTGSets as $MTGSet) {
			$Sets->Items[] = [$MTGSet->Set_Id, $MTGSet->Set_Name, Carbon::parse($MTGSet->Set_Release_Date)->format('Y-m-d')];
		}

		$Data = $this->MergeData($Title,$Images,$Attributes,$MTGData->Card_Type,$Sets);

		return view('Details.Details', $this->mergeDetailsOptions($this->Page,[
			'Title' => $Title,
			'Data' => $Data
		]));
	}
}
