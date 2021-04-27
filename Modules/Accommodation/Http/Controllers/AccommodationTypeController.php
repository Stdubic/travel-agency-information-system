<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AccommodationType;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeCreateRequest;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeEditRequest;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeListRequest;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeStoreRequest;
use Modules\Accommodation\Http\Requests\AccommodationType\AccommodationTypeUpdateRequest;

class AccommodationTypeController extends Controller
{
    /**
     * Lists accommodation type entity
     *
     * @param AccommodationTypeListRequest $request
     * @param AccommodationType $accommodationType
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AccommodationTypeListRequest $request, AccommodationType $accommodationType)
    {
        $types = $accommodationType->withTranslation()->paginate(50);

        return view('accommodation::accommodation.type.list', compact('types'));
    }

    /**
     * Returns page for creating new accommodation type entity
     *
     * @param AccommodationTypeCreateRequest $request
     * @param AccommodationType $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AccommodationTypeCreateRequest $request,  AccommodationType $type)
    {
        return view('accommodation::accommodation.type.create', compact('type'));
    }

    /**
     * Store accommodation type entity
     *
     * @param AccommodationTypeStoreRequest $request
     * @param AccommodationType $accommodationType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationTypeStoreRequest $request, AccommodationType $accommodationType)
    {
        $request->merge($request->input('translation'));

        try {
            $accommodationType->create($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.type.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.type.store.success'));
    }

    /**
     * Returns page for editing accommodation type entity
     *
     * @param AccommodationTypeEditRequest $request
     * @param AccommodationType $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AccommodationTypeEditRequest $request, AccommodationType $type)
    {
        $type->load(['translations' => function ($query) {
            $query->orderBy('accommodation_type_translations.created_at', 'desc');
        }]);

        $type->formattedTranslations = $type->translations->keyBy('locale');

        return view('accommodation::accommodation.type.create', compact('type'));
    }

    /**
     * Updates accommodation type entity
     *
     * @param AccommodationTypeUpdateRequest $request
     * @param AccommodationType $type
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccommodationTypeUpdateRequest $request, AccommodationType $type)
    {

        try {
            $type->update([
                'standard_capacity' => $request->input('standard_capacity', 0),
                'max_capacity' => $request->input('max_capacity', 0),
                'min_capacity' => $request->input('min_capacity', 0),
                'max_adults' => $request->input('max_adults', 0),
                'min_children' => $request->input('min_children', 0),
                'description' => $request->input('description', 0),
            ]);

            foreach ($request->input('translation') as $language => $title) {
                foreach ($title as $key => $value) {
                    $query[$key] = $request->input("translation.{$language}.{$key}");
                }

                $type->translations()->updateOrCreate(['locale' => $language], $query);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.type.update.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.type.update.success'));
    }

    /**
     * Deletes accommodation type
     *
     * @param AccommodationTypeDeleteRequest $request
     * @param AccommodationType $accommodationType
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AccommodationTypeDeleteRequest $request, AccommodationType $accommodationType)
    {
        $type = $accommodationType->find($request->route('id'));
        try {
            $type->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.type.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.type.delete.success'));
    }
}
