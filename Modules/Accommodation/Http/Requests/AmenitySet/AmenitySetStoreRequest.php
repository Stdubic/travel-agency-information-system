<?php

namespace Modules\Accommodation\Http\Requests\AmenitySet;

use Modules\Base\Services\LanguageConfig;
use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AmenitySetStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-amenity-set')) {
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
            $rules["translation.{$langCode}.description"] = ['required', 'string'];
        }

        return $rules;
    }
}
