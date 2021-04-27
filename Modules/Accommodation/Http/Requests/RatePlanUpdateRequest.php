<?php

namespace Modules\Accommodation\Http\Requests;


use Modules\Base\Http\Requests\BaseRequest;

class RatePlanUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'accommodation_object' => 'required|int|exists:accommodation_objects,id',
            'name' => 'required|string',
            'type' => 'required|string|in:rate-one-time,rate-per-person-per-night,rate-per-person,rate-per-night,rate-per-unit-occupancy',
            'pricelist_types_json' => 'nullable|json',
        ];
    }
}
