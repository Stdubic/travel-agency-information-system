<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\AccommodationUnit;
use Modules\Accommodation\Entities\AccommodationUnitType;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitCreateRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitEditRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitListRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitStoreRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnit\AccommodationUnitUpdateRequest;

class AccommodationUnitController extends Controller
{
    /**
     * Lists accommodation unit entity
     *
     * @param AccommodationUnitListRequest $request
     * @param AccommodationUnit $accommodationUnit
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AccommodationUnitListRequest $request, AccommodationUnit $accommodationUnit)
    {
        $units = $accommodationUnit->whereHas('object' , function($q){
            $q->owner();
        })->with('object')->paginate(50);

        return view('accommodation::accommodation.unit.list', compact('units'));
    }

    /**
     * Display form for creating accommodation unit
     *
     * @param AccommodationUnitCreateRequest $request
     * @param AccommodationUnit $accommodationUnit
     * @param AccommodationObject $accommodationObject
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AccommodationUnitCreateRequest $request, AccommodationUnit $accommodationUnit, AccommodationObject $accommodationObject, AccommodationUnitType $unitType)
    {
        $accommodationObjectArray = $accommodationObject->pluck('name', 'id');

        $types = $unitType->withTranslation()->get();

        $accommodationUnitTypeArray = [];

        foreach ($types as $type) {
            $accommodationUnitTypeArray[$type->translations->first()->accommodation_unit_type_id] = $type->translations->first()->title;
        }

        return view('accommodation::accommodation.unit.create', compact(['accommodationUnit', 'accommodationObjectArray', 'accommodationUnitTypeArray']));
    }

    /**
     * Store accommodation unit entity
     *
     * @param AccommodationUnitStoreRequest $request
     * @param AccommodationUnit $accommodationUnit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationUnitStoreRequest $request, AccommodationUnit $accommodationUnit)
    {
        try {
            $accommodationUnit = $accommodationUnit->create([
                'name' => $request->input('name'),
                'accommodation_object_id' => $request->input('accommodation_object'),
                'accommodation_unit_type_id' => $request->input('unit_type'),
                'basic_bed_number' => $request->input('basic_bed_num'),
                'additional_bed_number' => $request->input('additional_bed_num'),
                'position' => $request->input('position'),
                'view' => $request->input('view'),
                'qty' => $request->input('qty'),
                'rating' => $request->input('rating'),
                'is_active' => $request->input('active')
            ]);

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.unit.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.store.success'));
    }


    /**
     * Returns form for editing accommodation unit
     *
     * @param AccommodationUnitEditRequest $request
     * @param AccommodationUnit $accommodationUnit
     * @param AccommodationObject $accommodationObject
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AccommodationUnitEditRequest $request, AccommodationUnit $accommodationUnit, AccommodationObject $accommodationObject, AccommodationUnitType $unitType)
    {
        $accommodationObjectArray = $accommodationObject->pluck('name', 'id');

        $types = $unitType->withTranslation()->get();

        $accommodationUnitTypeArray = [];

        foreach ($types as $type) {
            $accommodationUnitTypeArray[$type->translations->first()->accommodation_unit_type_id] = $type->translations->first()->title;
        }

        return view('accommodation::accommodation.unit.create', compact(['accommodationUnit', 'accommodationObjectArray', 'accommodationUnitTypeArray']));
    }


    /**
     * Update accommodation unit resource
     *
     * @param AccommodationUnitUpdateRequest $request
     * @param AccommodationUnit $accommodationUnit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccommodationUnitUpdateRequest $request, AccommodationUnit $accommodationUnit)
    {
        try {
            $accommodationUnit->update([
                'name' => $request->input('name'),
                'accommodation_object_id' => $request->input('accommodation_object'),
                'accommodation_unit_type_id' => $request->input('unit_type'),
                'basic_bed_number' => $request->input('basic_bed_num'),
                'additional_bed_number' => $request->input('additional_bed_num'),
                'position' => $request->input('position'),
                'view' => $request->input('view'),
                'qty' => $request->input('qty'),
                'rating' => $request->input('rating'),
                'is_active' => $request->input('active')
            ]);

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.unit.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.update.success'));
    }

    /**
     * Delete accommodation unit
     *
     * @param AccommodationUnitDeleteRequest $request
     * @param AccommodationUnit $unit
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AccommodationUnitDeleteRequest $request, AccommodationUnit $unit)
    {
        $unit = $unit->find($request->route('id'));
        try {
            $unit->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.unit.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.delete.success'));
    }
}
