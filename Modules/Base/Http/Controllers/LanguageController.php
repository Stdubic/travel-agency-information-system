<?php

namespace Modules\Base\Http\Controllers;

use \Illuminate\Config\Repository as Config;
use Modules\Base\Entities\Language;
use Modules\Base\Http\Requests\Language\LanguageCreateRequest;
use Modules\Base\Http\Requests\Language\LanguageDeleteRequest;
use Modules\Base\Http\Requests\Language\LanguageManageRequest;
use Modules\Base\Http\Requests\Language\LanguageManageStoreRequest;
use Modules\Base\Http\Requests\Language\LanguageStoreRequest;
use Modules\Base\Http\Requests\Language\LanguageUpdateRequest;

class LanguageController extends Controller
{
    /**
     * Returns form for creating language
     *
     * @param LanguageCreateRequest $request
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LanguageCreateRequest $request, Language $language)
    {
        return view('base::language.create', compact(['language']));
    }

    /**
     * Stores new language entity
     *
     * @param LanguageStoreRequest $request
     * @param Language $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LanguageStoreRequest $request, Language $language)
    {
        try {
            $language->create($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.settings.language.create.error'));
        }

        return redirect()->back()->with('success', __('base::base.settings.language.create.success'));
    }

    /**
     * List languages
     *
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Language $language)
    {
        $languages = $language->paginate(50);

        return view('base::language.list', compact(['languages']));
    }

    /**
     * Returns form for editing language
     *
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Language $language)
    {
        return view('base::language.create', compact(['language']));
    }

    /**
     * Updates language entity
     *
     * @param LanguageUpdateRequest $request
     * @param Language $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LanguageUpdateRequest $request, Language $language)
    {
        try {
            $language->update($request->input());
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.settings.language.update.error'));
        }

        return redirect()->back()->with('success', __('base::base.settings.language.update.success'));
    }

    /**
     * Returns form for managing language
     *
     * @param LanguageManageRequest $request
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageForm(LanguageManageRequest $request, Language $language)
    {
        $languageArray = $this->getLanguages($language);

        return view('base::language.manage', compact(['languageArray']));
    }

    /**
     * Changes language settings
     *
     * @param LanguageManageStoreRequest $request
     * @param Config $config
     * @param Language $language
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage(LanguageManageStoreRequest $request, Config $config, Language $language)
    {
        $langConfigNew = array_keys($request->input('languages'));

        $langConfigOld = $language->where('active', 1)->pluck('code')->toArray();

        $toDisable = array_diff($langConfigOld, $langConfigNew);

        $toEnable = array_diff($langConfigNew, $langConfigOld);

        foreach ($toDisable as $lang) {
            $language->where('code', $lang)->update(['active' => 0]);
        }

        foreach ($toEnable as $lang) {
            $language->where('code', $lang)->update(['active' => 1]);
        }

        $languageArray = $this->getLanguages($language);

        return view('base::language.manage', compact(['languageArray']));
    }


    /**
     * Deletes language entity
     *
     * @param LanguageDeleteRequest $request
     * @param Language $language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(LanguageDeleteRequest $request, Language $language)
    {
        $language = $language->find($request->route('id'));

        try {
            $language->delete();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', __('base::base.settings.language.delete.error'));
        }

        return redirect()->back()->with('success', __('base::base.settings.language.delete.success'));
    }

    /**
     * Get all languages from database
     *
     * @param Language $language
     * @return array
     */
    protected function getLanguages(Language $language)
    {
        $languages = $language->get();

        $languageArray = [];

        foreach ($languages as $language) {
            $languageArray[$language->code] = [
                'name' => $language->name,
                'active' => $language->active,
            ];
        }

        return $languageArray;
    }
}
