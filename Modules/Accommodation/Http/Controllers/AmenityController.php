<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\Amenity;
use Modules\Accommodation\Entities\AmenitySet;
use Modules\Accommodation\Http\Requests\Amenity\AmenityCreateRequest;
use Modules\Accommodation\Http\Requests\Amenity\AmenityEditRequest;
use Modules\Accommodation\Http\Requests\Amenity\AmenityListRequest;
use Modules\Accommodation\Http\Requests\Amenity\AmenityDeleteRequest;
use Modules\Accommodation\Http\Requests\Amenity\AmenityStoreRequest;
use Modules\Accommodation\Http\Requests\Amenity\AmenityUpdateRequest;

class AmenityController extends Controller
{
    /**
     * Lists amenities
     *
     * @param AmenityListRequest $request
     * @param Amenity $amenity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AmenityListRequest $request, Amenity $amenity)
    {
        $amenities = $amenity->with(['translations', 'amenitySets'=> function ($query) {
            $query->withTranslation();
        }])->paginate(50);

        return view('accommodation::accommodation.amenity.list', compact('amenities'));
    }

    /**
     * Returns page for creating new amenity entity
     *
     * @param AmenityCreateRequest $request
     * @param Amenity $amenity
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AmenityCreateRequest $request, Amenity $amenity, AmenitySet $amenitySet)
    {
        $sets = $amenitySet->withTranslation()->get();

        $setsSelectArray = [];

        foreach ($sets as $set) {
            $setsSelectArray[$set->translations->first()->amenity_set_id] = $set->translations->first()->title;
        }

        $setArray = array_merge([0 => 'Choose'], $setsSelectArray);

        return view('accommodation::accommodation.amenity.create', compact(['amenity', 'setArray']));
    }

    /**
     * Store amenity entity
     *
     * @param AmenityStoreRequest $request
     * @param Amenity $amenity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AmenityStoreRequest $request, Amenity $amenity)
    {
        $request->merge($request->input('translation'));

        try {
            $amenity->create($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.amenity.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.store.success'));
    }


    /**
     * Edit amenity entity
     *
     * @param AmenityEditRequest $request
     * @param Amenity $amenity
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AmenityEditRequest $request, Amenity $amenity, AmenitySet $amenitySet)
    {
        $amenity->load(['translations' => function ($query) {
            $query->orderBy('amenity_translations.created_at', 'desc');
        }]);

        $amenity->formattedTranslations = $amenity->translations->keyBy('locale');

        $sets = $amenitySet->withTranslation()->get();

        $setsSelectArray = [];

        foreach ($sets as $set) {
            $setsSelectArray[$set->translations->first()->amenity_set_id] = $set->translations->first()->title;
        }

        $setArray = array_merge([0 => 'Choose'], $setsSelectArray);

        return view('accommodation::accommodation.amenity.create', compact(['amenity', 'setArray']));
    }

    /**
     * Update amenity entity
     *
     * @param AmenityUpdateRequest $request
     * @param Amenity $amenity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AmenityUpdateRequest $request, Amenity $amenity)
    {
        try {
            $amenity->update([
                'text_field' => $request->input('text_field', 0),
                'amenity_set_id' => $request->input('amenity_set_id'),
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $amenity->translations()->updateOrCreate(['locale' => $language], $query);
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.amenity.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.update.success'));
    }

    /**
     * Deletes amenity
     *
     * @param AmenityDeleteRequest $request
     * @param Amenity $amenity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AmenityDeleteRequest $request , Amenity $amenity)
    {
        $amenity = $amenity->find($request->route('id'));
        try {
            $amenity->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.amenity.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.delete.success'));
    }
}
