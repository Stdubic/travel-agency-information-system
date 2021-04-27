<?php

namespace Modules\Accommodation\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AccommodationObject;
use Modules\Accommodation\Entities\AccommodationReservation;
use Modules\Accommodation\Entities\AccommodationUnit;
use Modules\Accommodation\Entities\RatePlan;
use Modules\Accommodation\Http\Requests\AccommodationReservationStoreRequest;
use Modules\Accommodation\Http\Requests\RatePlanDeleteRequest;
use Modules\Accommodation\Http\Requests\RatePlanStoreRequest;
use Modules\Accommodation\Http\Requests\RatePlanUpdateRequest;

class ReservationController extends Controller
{
//    /**
//     * List rate plans
//     *
//     * @param RatePlan $ratePlan
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function index(RatePlan $ratePlan)
//    {
//        $rates = $ratePlan->with('object')->paginate(50);
//
//        return view('accommodation::accommodation.rate.list', compact('rates'));
//    }


    public function create(AccommodationReservation $reservation, AccommodationObject $accommodationObject, AccommodationUnit $accommodationUnit , RatePlan $ratePlan)
    {
        $accommodationObjectArray = $accommodationObject->pluck('name', 'id');

        $accommodationUnitArray = $accommodationUnit->pluck('name', 'id');

        $ratePlanArray = $ratePlan->pluck('name', 'id');

        return view('accommodation::accommodation.reservation.create', compact(['reservation', 'accommodationObjectArray', 'accommodationUnitArray', 'ratePlanArray']));
    }

    /**
     * Store reservation entity
     *
     * @param RatePlanStoreRequest $request
     * @param RatePlan $ratePlan
     * @param Carbon $carbon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationReservationStoreRequest $request, AccommodationReservation $reservation, Carbon $carbon)
    {
        $formattedDate = explode(' - ', $request->input('date_range'));

        $ratePeriod = [];

        foreach ($request->input('price') as $date => $value) {
            if( ($value != null) && ($request->input('room')[$date] != null) && ($request->input('stay')[$date] != null) ) {
                $ratePeriod[] = [
                    'period' => $date,
                    'price' => $value,
                    'rooms_to_sell' => $request->input('room')[$date],
                    'minimum_stay' => $request->input('stay')[$date],
                ];
            }
        }

        try {
            $ratePlan = $ratePlan->create([
                'accommodation_object_id' => $request->input('accommodation_object'),
                'name' => $request->input('name'),
                'service' => $request->input('service'),
                'type' => $request->input('type'),
                'base_price' => $request->input('base_price'),
                'b2c_margin_type' => $request->input('b2c_margin_type'),
                'b2c_margin' => $request->input('b2c_margin'),
                'min_person' => $request->input('min_person'),
                'min_stay' => $request->input('min_stay'),
                'max_stay' => $request->input('max_stay'),
                'release_period' => $request->input('release_period'),
                'sojourn_tax' => $request->input('sojourn_tax'),
                'currency' => $request->input('currency'),
                'start' => $formattedDate[0],
                'stop' => $formattedDate[1],
            ]);

            $ratePlan->units()->attach($request->input('accommodation_units'));

            $ratePlan->periods()->createMany($ratePeriod);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.rate.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.rate.store.success'));
    }
//
//    /**
//     * Updates rate plan object
//     *
//     * @param RatePlanUpdateRequest $request
//     * @param RatePlan $rate
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function update(RatePlanUpdateRequest $request, RatePlan $rate)
//    {
//        $formattedDate = explode(' - ', $request->input('date_range'));
//
//        try {
//            $rate->update([
//                'accommodation_object_id' => $request->input('accommodation_object'),
//                'name' => $request->input('name'),
//                'service' => $request->input('service'),
//                'type' => $request->input('type'),
//                'base_price' => $request->input('base_price'),
//                'b2c_margin_type' => $request->input('b2c_margin_type'),
//                'b2c_margin' => $request->input('b2c_margin'),
//                'min_person' => $request->input('min_person'),
//                'min_stay' => $request->input('min_stay'),
//                'max_stay' => $request->input('max_stay'),
//                'release_period' => $request->input('release_period'),
//                'sojourn_tax' => $request->input('sojourn_tax'),
//                'currency' => $request->input('currency'),
//                'start' => $formattedDate[0],
//                'stop' => $formattedDate[1],
//            ]);
//
//            $rate->units()->sync($request->input('accommodation_units'));
//        } catch (\Exception $exception) {
//            return redirect()->back()->with('error', __('accommodation::accommodation.rate.update.error'));
//        }
//
//        return redirect()->back()->with('success', __('accommodation::accommodation.rate.update.success'));
//    }
//
//
//    /**
//     * Edit rate plan entity
//     *
//     * @param RatePlan $rate
//     * @param AccommodationObject $accommodationObject
//     * @param AccommodationUnit $accommodationUnit
//     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
//     */
//    public function edit(RatePlan $rate, AccommodationObject $accommodationObject, AccommodationUnit $accommodationUnit)
//    {
//        $accommodationObjectArray = $accommodationObject->pluck('name', 'id');
//
//        $accommodationUnitArray = $accommodationUnit->pluck('name', 'id');
//
//        $rate->load(['units']);
//
//        $selectedUnits = $rate->units->pluck('id');
//
//        $rate->date_range = $rate->start . ' - ' . $rate->stop;
//
//        return view('accommodation::accommodation.rate.create', compact(['rate', 'accommodationObjectArray', 'accommodationUnitArray', 'selectedUnits']));
//    }
//
//
//    /**
//     * Delete rate plan entity
//     *
//     * @param RatePlanDeleteRequest $request
//     * @param RatePlan $ratePlan
//     * @return \Illuminate\Http\RedirectResponse
//     */
//    public function destroy(RatePlanDeleteRequest $request, RatePlan $ratePlan)
//    {
//        $ratePlan = $ratePlan->find($request->route('id'));
//        try {
//            $ratePlan->delete();
//        } catch (\Exception $exception) {
//            return redirect()->back()->with('error', __('accommodation::accommodation.rate.delete.error'));
//        }
//
//        return redirect()->back()->with('success', __('accommodation::accommodation.rate.delete.success'));
//    }
}
