<?php

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

//Route::prefix('accommodation')->group(function() {
//    Route::get('/', 'AccomodationController@index');
//});

//Accommodation type

Route::group(['middleware' => ['auth']], function () {

    $this->get('accommodation/type/list', 'AccommodationTypeController@index')->name('accommodation.type.list');
    $this->get('accommodation/type/create', 'AccommodationTypeController@create')->name('accommodation.type.create');
    $this->post('accommodation/type/store', 'AccommodationTypeController@store')->name('accommodation.type.store');
    $this->get('accommodation/type/edit/{type}', 'AccommodationTypeController@edit')->name('accommodation.type.edit');
    $this->put('accommodation/type/update/{type}',
        'AccommodationTypeController@update')->name('accommodation.type.update');
    $this->get('accommodation/type/delete/{id}',
        'AccommodationTypeController@destroy')->name('accommodation.type.delete');

//Accommodation category

    $this->get('accommodation/category/list',
        'AccommodationCategoryController@index')->name('accommodation.category.list');
    $this->get('accommodation/category/create',
        'AccommodationCategoryController@create')->name('accommodation.category.create');
    $this->post('accommodation/category/store',
        'AccommodationCategoryController@store')->name('accommodation.category.store');
    $this->get('accommodation/category/edit/{category}',
        'AccommodationCategoryController@edit')->name('accommodation.category.edit');
    $this->put('accommodation/category/update/{category}',
        'AccommodationCategoryController@update')->name('accommodation.category.update');
    $this->get('accommodation/category/delete/{id}',
        'AccommodationCategoryController@destroy')->name('accommodation.category.delete');

//Location
    //Region
    $this->get('accommodation/location/region/create',
        'LocationController@createRegion')->name('accommodation.location.region.create');
    $this->post('accommodation/location/region/store',
        'LocationController@storeRegion')->name('accommodation.location.region.store');
    $this->get('accommodation/location/region/list',
        'LocationController@listRegions')->name('accommodation.location.region.list');
    $this->get('accommodation/location/region/edit/{region}',
        'LocationController@editRegion')->name('accommodation.location.region.edit');
    $this->put('accommodation/location/region/update/{region}',
        'LocationController@updateRegion')->name('accommodation.location.region.update');
    $this->get('accommodation/location/region/delete/{id}',
        'LocationController@destroyRegion')->name('accommodation.location.region.delete');
    //City
    $this->get('accommodation/location/city/create',
        'LocationController@createCity')->name('accommodation.location.city.create');
    $this->post('accommodation/location/city/store',
        'LocationController@storeCity')->name('accommodation.location.city.store');
    $this->get('accommodation/location/city/list',
        'LocationController@listCities')->name('accommodation.location.city.list');
    $this->get('accommodation/location/city/edit/{city}',
        'LocationController@editCity')->name('accommodation.location.city.edit');
    $this->put('accommodation/location/city/update/{city}',
        'LocationController@updateCity')->name('accommodation.location.city.update');
    $this->get('accommodation/location/city/delete/{id}',
        'LocationController@destroyCity')->name('accommodation.location.city.delete');


//Accommodation object

    $this->get('accommodation/object/list', 'AccommodationObjectController@index')->name('accommodation.object.list');
    $this->get('accommodation/object/create',
        'AccommodationObjectController@create')->name('accommodation.object.create');
    $this->post('accommodation/object/store',
        'AccommodationObjectController@store')->name('accommodation.object.store');
    $this->post('accommodation/object/image/destroy',
        'AccommodationObjectController@destroyImage')->name('accommodation.object.image.delete');
//    $this->post('accommodation/object/image/store',
//        'AccommodationObjectController@storeImage')->name('accommodation.object.store');
    $this->get('accommodation/object/delete/{id}',
        'AccommodationObjectController@destroy')->name('accommodation.object.delete');
    $this->get('accommodation/object/edit/{object}',
        'AccommodationObjectController@edit')->name('accommodation.object.edit');
    $this->put('accommodation/object/edit/{object}',
        'AccommodationObjectController@update')->name('accommodation.object.update');
    $this->post('accommodation/object/manager/sync/{object}',
        'AccommodationObjectController@channelManagerSync')->name('accommodation.object.sync');

//Accommodation unit

    $this->get('accommodation/unit/list', 'AccommodationUnitController@index')->name('accommodation.unit.list');
    $this->get('accommodation/unit/create', 'AccommodationUnitController@create')->name('accommodation.unit.create');
    $this->post('accommodation/unit/store', 'AccommodationUnitController@store')->name('accommodation.unit.store');
    $this->get('accommodation/unit/edit/{accommodationUnit}', 'AccommodationUnitController@edit')->name('accommodation.unit.edit');
    $this->put('accommodation/unit/update/{accommodationUnit}', 'AccommodationUnitController@update')->name('accommodation.unit.update');
    $this->get('accommodation/unit/delete/{id}', 'AccommodationUnitController@destroy')->name('accommodation.unit.delete');

//Accommodation unit type

    $this->get('accommodation/unit/type/list', 'AccommodationUnitTypeController@index')->name('accommodation.unit.type.list');
    $this->get('accommodation/unit/type/create', 'AccommodationUnitTypeController@create')->name('accommodation.unit.type.create');
    $this->post('accommodation/unit/type/store', 'AccommodationUnitTypeController@store')->name('accommodation.unit.type.store');
    $this->get('accommodation/unit/type/edit/{unitType}', 'AccommodationUnitTypeController@edit')->name('accommodation.unit.type.edit');
    $this->put('accommodation/unit/type/update/{unitType}', 'AccommodationUnitTypeController@update')->name('accommodation.unit.type.update');
    $this->get('accommodation/unit/type/delete/{id}', 'AccommodationUnitTypeController@destroy')->name('accommodation.unit.type.delete');


//Amenities
    $this->get('amenity/list', 'AmenityController@index')->name('accommodation.amenity.list');
    $this->get('amenity/create', 'AmenityController@create')->name('accommodation.amenity.create');
    $this->post('amenity/store', 'AmenityController@store')->name('accommodation.amenity.store');
    $this->get('amenity/edit/{amenity}', 'AmenityController@edit')->name('accommodation.amenity.edit');
    $this->put('amenity/update/{amenity}', 'AmenityController@update')->name('accommodation.amenity.update');
    $this->get('amenity/delete/{id}', 'AmenityController@destroy')->name('accommodation.amenity.delete');

//Amenity set
    $this->get('amenity/set/list', 'AmenitySetController@index')->name('accommodation.amenity.set.list');
    $this->get('amenity/set/create', 'AmenitySetController@create')->name('accommodation.amenity.set.create');
    $this->post('amenity/set/store', 'AmenitySetController@store')->name('accommodation.amenity.set.store');
    $this->get('amenity/set/edit/{amenitySet}', 'AmenitySetController@edit')->name('accommodation.amenity.set.edit');
    $this->put('amenity/set/update/{amenitySet}', 'AmenitySetController@update')->name('accommodation.amenity.set.update');
    $this->get('amenity/set/delete/{id}', 'AmenitySetController@destroy')->name('accommodation.amenity.set.delete');



//Rate plan

    $this->get('accommodation/rate/list', 'RatePlanController@index')->name('accommodation.rate.plan.list');
    $this->get('accommodation/rate/create', 'RatePlanController@create')->name('accommodation.rate.plan.create');
    $this->post('accommodation/rate/store', 'RatePlanController@store')->name('accommodation.rate.plan.store');
    $this->get('accommodation/rate/delete/{id}', 'RatePlanController@destroy')->name('accommodation.rate.plan.delete');
    $this->get('accommodation/rate/edit/{rate}','RatePlanController@edit')->name('accommodation.rate.plan.edit');
    $this->put('accommodation/rate/update/{rate}','RatePlanController@update')->name('accommodation.rate.plan.update');

//Reservation

    //$this->get('accommodation/rate/list', 'RatePlanController@index')->name('accommodation.rate.plan.list');
    $this->get('accommodation/reservation/create', 'ReservationController@create')->name('accommodation.reservations.create');
    $this->post('accommodation/reservation/store', 'ReservationController@store')->name('accommodation.reservations.store');
//    $this->get('accommodation/rate/delete/{id}', 'RatePlanController@destroy')->name('accommodation.rate.plan.delete');
//    $this->get('accommodation/rate/edit/{rate}','RatePlanController@edit')->name('accommodation.rate.plan.edit');
//    $this->put('accommodation/rate/update/{rate}','RatePlanController@update')->name('accommodation.rate.plan.update');
});
