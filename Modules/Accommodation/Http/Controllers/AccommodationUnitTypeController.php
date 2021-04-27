<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AccommodationUnitType;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeStoreRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeUpdateRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeCreateRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeEditRequest;
use Modules\Accommodation\Http\Requests\AccommodationUnitType\AccommodationUnitTypeListRequest;


class AccommodationUnitTypeController extends Controller
{
    /**
     * Lists accommodation unit type entity
     *
     * @param AccommodationUnitTypeListRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AccommodationUnitTypeListRequest $request, AccommodationUnitType $unitType)
    {
        $unitType = $unitType->withTranslation()->paginate(50);

        return view('accommodation::accommodation.unit.type.list', compact('unitType'));
    }

    /**
     * Returns page for creating new accommodation unit type entity
     *
     * @param AccommodationUnitTypeCreateRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AccommodationUnitTypeCreateRequest $request, AccommodationUnitType $unitType)
    {
        return view('accommodation::accommodation.unit.type.create', compact('unitType'));
    }

    /**
     * Store accommodation unit type entity
     *
     * @param AccommodationUnitTypeStoreRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationUnitTypeStoreRequest $request, AccommodationUnitType $unitType)
    {
        try {
            $unitType->create($request->input('translation'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.unit.type.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.type.store.success'));
    }

    /**
     * Returns page for editing accommodation unit type entity
     *
     * @param AccommodationUnitTypeEditRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AccommodationUnitTypeEditRequest $request, AccommodationUnitType $unitType)
    {
        $unitType->load(['translations' => function ($query) {
            $query->orderBy('accommodation_unit_type_translations.created_at', 'desc');
        }]);

        $unitType->formattedTranslations = $unitType->translations->keyBy('locale');

        return view('accommodation::accommodation.unit.type.create', compact('unitType'));
    }

    /**
     * Updates accommodation unit type entity
     *
     * @param AccommodationUnitTypeUpdateRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccommodationUnitTypeUpdateRequest $request, AccommodationUnitType $unitType)
    {
        foreach ($request->input('translation') as $language => $title) {
            foreach ($title as $key => $value) {
                $query[$key] = $request->input("translation.{$language}.{$key}");
            }

            try {
                $unitType->translations()->updateOrCreate(['locale' => $language], $query);
            } catch (\Exception $exception) {
                return redirect()->back()->with('error', __('accommodation::accommodation.unit.type.update.error'));
            }
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.type.update.success'));
    }

    /**
     * Deletes accommodation unit type
     *
     * @param AccommodationUnitTypeDeleteRequest $request
     * @param AccommodationUnitType $unitType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AccommodationUnitTypeDeleteRequest $request, AccommodationUnitType $unitType)
    {
        $type = $unitType->find($request->route('id'));
        try {
            $type->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.unit.type.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.unit.type.delete.success'));
    }
}
