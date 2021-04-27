<?php

namespace Modules\Accommodation\Http\Controllers\Api;

use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\Country;
use Modules\Accommodation\Entities\Region;
use Modules\Accommodation\Http\Requests\Api\LocationCitiesGetRequest;
use Modules\Accommodation\Http\Requests\Api\LocationRegionsGetRequest;
use Modules\Base\Http\Controllers\Controller;
use Rinvex\Attributes\Models\Attribute;

class LocationController extends Controller
{

    /**
     * Get regions base on country
     *
     * @param LocationRegionsGetRequest $request
     * @param Country $country
     * @return array
     */
    public function getRegions(LocationRegionsGetRequest $request, Country $country)
    {
        $selectedCountry = $country->with('regions')->find($request->input('id'));

        if ($selectedCountry->regions()->count() === 0) {
            return [];
        } else {
            $regions = $selectedCountry->regions;
        }

        $results = [];

        foreach ($regions as $region) {
            $results[] =[
                'id' => $region->id,
                'name' => $region->name
            ];
        }

        return $results;
    }

    /**
     * Get cities based on region
     *
     * @param LocationCitiesGetRequest $request
     * @param Region $region
     * @return array
     */
    public function getCities(LocationCitiesGetRequest $request, Region $region)
    {
        $selectedRegion = $region->with('cities')->find($request->input('id'));

        if ($selectedRegion->cities()->count() === 0) {
            return [];
        } else {
            $cities = $selectedRegion->cities;
        }

        $results = [];

        foreach ($cities as $city) {
            $results[] =[
                'id' => $city->id,
                'name' => $city->name
            ];
        }

        return $results;
    }



    public function test(Attribute $attribute)
    {
//        $selectedRegion = $region->with('cities')->find($request->input('id'));
//
//        if ($selectedRegion->cities()->count() === 0) {
//            return [];
//        } else {
//            $cities = $selectedRegion->cities;
//        }
//
//        $results = [];
//
//        foreach ($cities as $city) {
//            $results[] =[
//                'id' => $city->id,
//                'name' => $city->name
//            ];
//        }
//
//        return $results;

        $attribute->create([
            'slug' => 'beach2',
            'type' => 'varchar',
            'name' => [
                'en' => 'Beach distance2',
                'de' => 'Beach dice2',
            ]
        ]);
    }
}
