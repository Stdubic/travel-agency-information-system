<?php

namespace Modules\Accommodation\Http\Requests\AccommodationType;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Services\LanguageConfig;

class AccommodationTypeUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-accommodation-object-type')) {
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

        $rules = array_merge($rules, [
            'standard_capacity' => 'required|integer',
            'max_capacity' => 'required|integer',
            'min_capacity' => 'required|integer',
            'max_adults' => 'required|integer',
            'min_children' => 'required|integer',
            'description' => 'boolean',
        ]);

        return $rules;
    }
}
