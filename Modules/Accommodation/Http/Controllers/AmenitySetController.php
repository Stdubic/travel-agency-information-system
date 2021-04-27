<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AmenitySet;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetCreateRequest;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetDeleteRequest;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetEditRequest;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetListRequest;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetStoreRequest;
use Modules\Accommodation\Http\Requests\AmenitySet\AmenitySetUpdateRequest;

class AmenitySetController extends Controller
{

    /**
     * Lists amenity sets
     *
     * @param AmenitySetListRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AmenitySetListRequest $request, AmenitySet $amenitySet)
    {
        $amenitySets = $amenitySet->withTranslation()->paginate(50);

        return view('accommodation::accommodation.amenity.set.list', compact('amenitySets'));
    }

    /**
     * Returns page for amenity set creation
     *
     * @param AmenitySetCreateRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AmenitySetCreateRequest $request, AmenitySet $amenitySet)
    {
        return view('accommodation::accommodation.amenity.set.create', compact(['amenitySet']));
    }

    /**
     * Store amenity set
     *
     * @param AmenitySetStoreRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AmenitySetStoreRequest $request , AmenitySet $amenitySet)
    {
        try {
            $amenitySet->create($request->input('translation'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.amenity.set.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.set.store.success'));
    }

    /**
     * Returns page for amenity set edit
     *
     * @param AmenitySetEditRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AmenitySetEditRequest $request, AmenitySet $amenitySet)
    {
        $amenitySet->load(['translations' => function ($query) {
            $query->orderBy('amenity_set_translations.created_at', 'desc');
        }]);

        $amenitySet->formattedTranslations = $amenitySet->translations->keyBy('locale');

        return view('accommodation::accommodation.amenity.set.create', compact('amenitySet'));
    }

    /**
     * Updates amenity set entity
     *
     * @param AmenitySetUpdateRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AmenitySetUpdateRequest $request, AmenitySet $amenitySet)
    {
        foreach ($request->input('translation') as $language => $title) {
            foreach ($title as $key => $value) {
                $query[$key] = $request->input("translation.{$language}.{$key}");
            }

            try {
                $amenitySet->translations()->updateOrCreate(['locale' => $language], $query);
            } catch (\Exception $exception) {
                return redirect()->back()->with('error', __('accommodation::accommodation.amenity.set.update.error'));
            }
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.set.update.success'));
    }


    /**
     * Deletes amenity set entity
     *
     * @param AmenitySetDeleteRequest $request
     * @param AmenitySet $amenitySet
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AmenitySetDeleteRequest $request, AmenitySet $amenitySet)
    {
        $amenitySet = $amenitySet->find($request->route('id'));
        try {
            $amenitySet->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.amenity.set.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.amenity.set.delete.success'));
    }
}
