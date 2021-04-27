<?php

namespace Modules\Accommodation\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Accommodation\Entities\AccommodationCategory;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryCreateRequest;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryEditRequest;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryStoreRequest;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryDeleteRequest;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryUpdateRequest;
use Modules\Accommodation\Http\Requests\AccommodationCategory\AccommodationCategoryListRequest;

class AccommodationCategoryController extends Controller
{
    /**
     * Accommodation category list
     *
     * @param AccommodationCategoryListRequest $request
     * @param AccommodationCategory $accommodationCategory
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(AccommodationCategoryListRequest $request, AccommodationCategory $accommodationCategory)
    {
        $categories = $accommodationCategory->withTranslation()->paginate(50);

        return view('accommodation::accommodation.category.list', compact('categories'));
    }

    /**
     * Accommodation category create page
     *
     * @param AccommodationCategoryCreateRequest $request
     * @param AccommodationCategory $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AccommodationCategoryCreateRequest $request, AccommodationCategory $category)
    {
        return view('accommodation::accommodation.category.create', compact('category'));
    }

    /**
     * Store accommodation category entity
     *
     * @param AccommodationCategoryStoreRequest $request
     * @param AccommodationCategory $accommodationCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccommodationCategoryStoreRequest $request, AccommodationCategory $accommodationCategory)
    {
        try {
            $accommodationCategory->create($request->input('translation'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.category.store.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.category.store.success'));
    }

    /**
     * Returns accommodation category edit page
     *
     * @param AccommodationCategoryEditRequest $request
     * @param AccommodationCategory $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AccommodationCategoryEditRequest $request, AccommodationCategory $category)
    {
        $category->load(['translations' => function ($query) {
            $query->orderBy('accommodation_category_translations.created_at', 'desc');
        }]);

        $category->formattedTranslations = $category->translations->keyBy('locale');

        return view('accommodation::accommodation.category.create', compact('category'));
    }

    /**
     * Updates accommodation category entity
     *
     * @param AccommodationCategoryUpdateRequest $request
     * @param AccommodationCategory $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccommodationCategoryUpdateRequest $request, AccommodationCategory $category)
    {
        foreach ($request->input('translation') as $language => $title) {
            foreach ($title as $key => $value) {
                $query[$key] = $request->input("translation.{$language}.{$key}");
            }

            try {
                $category->translations()->updateOrCreate(['locale' => $language], $query);
            } catch (\Exception $exception) {
                return redirect()->back()->with('error', __('accommodation::accommodation.category.update.error'));
            }
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.category.update.success'));
    }

    /**
     * Deletes accommodation category
     *
     * @param AccommodationCategoryDeleteRequest $request
     * @param AccommodationCategory $accommodationCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AccommodationCategoryDeleteRequest $request, AccommodationCategory $accommodationCategory)
    {
        $type = $accommodationCategory->find($request->route('id'));

        try {
            $type->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('accommodation::accommodation.category.delete.error'));
        }

        return redirect()->back()->with('success', __('accommodation::accommodation.category.delete.success'));
    }
}
