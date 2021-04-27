<?php

namespace Modules\Accommodation\Http\Requests\AccommodationCategory;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Services\LanguageConfig;

class AccommodationCategoryUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-accommodation-object-category')) {
            return false;
        }

        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        foreach (LanguageConfig::get() as $langCode => $langName) {
            $rules["translation.{$langCode}.title"] = ['required', 'string'];
        }

        return $rules;
    }
}
