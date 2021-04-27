<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/accommodation', function (Request $request) {
    return $request->user();
});

$this->get('countries/region', 'Api\LocationController@getRegions')->name('countries.regions.select');
$this->get('regions/city', 'Api\LocationController@getCities')->name('regions.cities.select');

//$this->get('test', 'Api\LocationController@test')->name('regions.cities.select');

//Phobs

$this->post('phobs/rate/ammount', 'Api\PhobsController@postPhobsRateAmount')->name('phobs.rate.ammount');
$this->get('phobs/test', 'Api\PhobsController@test')->name('phobs.rate.ammount');
