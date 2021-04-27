<?php

namespace Modules\Accommodation\Http\Requests\Amenity;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Services\LanguageConfig;

class AmenityStoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-amenity')) {
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
            'amenity_set_id' => 'required|int|exists:amenity_sets,id',
            'text_field' => 'boolean',
        ]);

        return $rules;
    }
}
