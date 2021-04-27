<?php

namespace Modules\Accommodation\Http\Requests\AccommodationObject;

use Modules\Base\Services\LanguageConfig;
use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccommodationObjectUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if((!$user->can('update', $this->all()['object'])) || (!$user->can('update-accommodation-object'))) {
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
            $rules["translation.*.{$langCode}.alt"] = ['string'];
            $rules["translation.*.{$langCode}.description"] = ['string'];
            $rules["description_translation.{$langCode}.description"] = ['required', 'string'];
        }


        $additionalRules = [
            'name' => 'required|string',
            'type' => 'required|string|in:hotel,holiday_home,apartment_house,camp',
            'reception_phone' => 'required|string',
            'reception_email' => 'required|string',
            'website' => 'required|string',
            'address' => 'required|string',
            'time_zone' => 'required|string',
            'currency' => 'required|string',
            'added_tax' => 'required|int',
            'booking_email' => 'required|email',
            'office_phone' => 'required|string',
            'office_tax' => 'required|int',
            'bank_name' => 'required|string',
            'bank_office' => 'required|string',
            'bank_swift' => 'required|string',
            'account_number' => 'required|string',
            'company_name' => 'required|string',
            'bank_iban' => 'required|string',
            'object_rating' => 'required|int|in:1,2,3,4,5',
            'object_category' => 'required|array',
            'object_category.*' => 'required|int|exists:accommodation_categories,id',
            'channel_manager' => 'nullable|in:phobs,ratehawk',
            'channel_manager_code' => 'nullable|string|unique:accommodation_objects,channel_manager_code',
            'country_id' => 'required|int|exists:countries,id',
            'region_id' => 'required|int|exists:regions,id',
            'city_id' => 'required|int|exists:cities,id',
//            'sojourn_tax' => 'boolean',
//            'site_visibility' => 'boolean',
//            'admin_visibility' => 'boolean',
//            'allow_rating' => 'boolean',
//            'recommended' => 'boolean',
//            'medical' => 'boolean',
//            'household' => 'boolean',
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
            'owner' => 'required|string|exists:users,name',
            'contact_person' => 'required|string',
            'files' => 'array',
            'files.*' => 'image',
            'translation' => 'array',
            'description_translation' => 'required|array',
        ];

        return  array_merge($rules, $additionalRules);
    }
}
