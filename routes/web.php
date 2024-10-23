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

Route::group(['namespace' => 'App\Http\Controllers\DataManager'], function() {
    Route::get('/pokemon', 'PokemonController@index');
    Route::match(['get', 'post'], '/Getpokemons', 'PokemonController@GetPokemons');
    Route::get('/Pokemon/{PokemonNumber}', 'PokemonController@GetPokemonInfo');

    Route::get('/MTG', 'MtgController@index');
    Route::match(['get', 'post'], '/Getcards', 'MtgController@Getcards');
    Route::get('/MTG/{CardName}', 'MtgController@GetCardInfo');
});