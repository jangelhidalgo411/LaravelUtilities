<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'App\Http\Controllers\Apis'], function() {
    Route::get('/pokemon', 'PokemonController@index');//->name('PokemonApi');
    Route::match(['get', 'post'], '/Getpokemons', 'PokemonController@GetPokemons');
    Route::get('/GetPokemonInfo/{PokemonNumber}', 'PokemonController@GetPokemonInfo');
});

Route::group(['namespace' => 'App\Http\Controllers\Integrations'], function() {
    Route::get('/zendesk', 'ZendeskController@index');
    Route::get('/zendesk/{zendesk}', 'ZendeskController@Zendesk');
    Route::match(['get', 'post'], '/zendesk/{zendesk}/get', 'ZendeskController@GetZendeskDate');
});