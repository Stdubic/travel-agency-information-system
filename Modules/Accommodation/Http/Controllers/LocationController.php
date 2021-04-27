<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\City;
use Modules\Accommodation\Entities\Country;
use Modules\Accommodation\Entities\Region;
use Modules\Accommodation\Http\Requests\City\LocationCityCreateRequest;
use Modules\Accommodation\Http\Requests\City\LocationCityEditRequest;
use Modules\Accommodation\Http\Requests\City\LocationCityListRequest;
use Modules\Accommodation\Http\Requests\City\LocationCityDeleteRequest;
use Modules\Accommodation\Http\Requests\City\LocationCityStoreRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionCreateRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionDeleteRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionEditRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionListRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionStoreRequest;
use Modules\Accommodation\Http\Requests\City\LocationCityUpdateRequest;
use Modules\Accommodation\Http\Requests\Region\LocationRegionUpdateRequest;

class LocationController extends Controller
{
    /**
     * Display cities
     *
     * @param LocationCityListRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listCities(LocationCityListRequest $request, City $city)
    {
        $cities = $city->with('region', 'region.country')->paginate(50);

        return view('accommodation::accommodation.location.city.list', compact('cities'));
    }

    /**
     * Display regions
     *
     * @param LocationRegionListRequest $request
     * @param Region $region
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function listRegions(LocationRegionListRequest $request, Region $region)
    {
        $regions = $region->with('country')->paginate(50);

        return view('accommodation::accommodation.location.region.list', compact('regions'));
    }

    /**
     * Return form for creating new region
     *
     * @param LocationRegionCreateRequest $request
     * @param Region $region
     * @param Country $country
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createRegion(LocationRegionCreateRequest $request, Region $region, Country $country)
    {
        $countries = $country->pluck('global_name', 'code');

        return view('accommodation::accommodation.location.region.create', compact('countries', 'region'));
    }

    /**
     * Return form for creating new city
     *
     * @param LocationCityCreateRequest $request
     * @param Region $region
     * @param City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createCity(LocationCityCreateRequest $request, Region $region, City $city)
    {
        $regions = $region->pluck('name', 'id');

        return view('accommodation::accommodation.location.city.create', compact('regions', 'city'));
    }

    /**
     * Store new region
     *
     * @param LocationRegionStoreRequest $request
     * @param Country $country
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRegion(LocationRegionStoreRequest $request, Country $country)
    {
        $selectedCountry = $country->where('code', $request->input('country'))->firstOrFail();

        try {
            $selectedCountry->regions()->create([
                'name' => $request->input('region')
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.location.region.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.region.store.success'));
    }

    /**
     * Store new city
     *
     * @param LocationCityStoreRequest $request
     * @param Region $region
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCity(LocationCityStoreRequest $request, Region $region)
    {
        $selectedRegion = $region->find($request->input('region_id'));

        try {
            $selectedRegion->cities()->create([
                'name' => $request->input('city')
            ]);
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', __('accommodation::accommodation.location.city.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.city.store.success'));
    }

    /**
     * Return view for editing city
     *
     * @param LocationCityEditRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCity(LocationCityEditRequest $request, City $city)
    {
        return view('accommodation::accommodation.location.city.create', compact('city'));
    }

    /**
     * Return view for editing region
     *
     * @param LocationRegionEditRequest $request
     * @param Region $region
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRegion(LocationRegionEditRequest $request, Region $region)
    {
        return view('accommodation::accommodation.location.region.create', compact('region'));
    }

    /**
     * Update city entity
     *
     * @param LocationCityUpdateRequest $request
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCity(LocationCityUpdateRequest $request, City $city)
    {
        try {
            $city->update([
                'name' => $request->input('city')
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.location.city.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.city.update.success'));
    }

    /**
     * Update region entity
     *
     * @param LocationRegionUpdateRequest $request
     * @param Region $region
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRegion(LocationRegionUpdateRequest $request, Region $region)
    {
        try {
            $region->update([
                'name' => $request->input('region')
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.location.region.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.region.update.success'));
    }

    /**
     * Delete city
     *
     * @param LocationCityDeleteRequest $request
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyCity(LocationCityDeleteRequest $request, City $city)
    {
        $city = $city->find($request->route('id'));
        try {
            $city->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.location.city.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.city.delete.success'));
    }

    /**
     * Delete region
     *
     * @param LocationRegionDeleteRequest $request
     * @param Region $region
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyRegion(LocationRegionDeleteRequest $request, Region $region)
    {
        $region = $region->find($request->route('id'));
        try {
            $region->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.location.region.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.location.region.delete.success'));
    }
}
