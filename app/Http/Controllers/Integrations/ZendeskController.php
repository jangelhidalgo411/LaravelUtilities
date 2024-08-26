<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use GuzzleHttp\Client;
use Zendesk\API\HttpClient AS ZendeskAPI;
use Carbon\Carbon;
use Zendesk\API\Exceptions\ApiResponseException AS ApiResponseException; 


class ZendeskController extends Controller {
	protected $SubDomain = "";
	protected $User = "";
	protected $Token = "";

	public function index(Request $r) {
		return view('Integration/ZendeskIndex')
			->with('Title',$Title);
	}


	public function Zendesk($zendesk, Request $r) {



		$Client = new ZendeskAPI($this->SubDomain);
		$Client->setAuth('basic', ['username' => $this->User, 'token' => $this->Token]);

		//$AllOrg	 = $Client->organizations()->findAll(['page' => 1]);
		//$AllTickets = $Client->tickets()->findAll(['sort' => 'created_at','page' => 1]);
		//$AllUser	= $Client->users()->findAll(['page' => 1]);

		dd($AllTickets);

		return view('Integration/ZendeskTable')
			->with('Title',$Title);
	}


}
