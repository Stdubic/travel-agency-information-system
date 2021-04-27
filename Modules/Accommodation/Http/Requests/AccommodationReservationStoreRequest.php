<?php

namespace Modules\Accommodation\Http\Requests;

use Illuminate\Support\Facades\Config;
use Modules\Base\Http\Requests\BaseRequest;

class AccommodationReservationStoreRequest extends BaseRequest
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
            'accommodation_object' => 'required|integer|exists:accommodation_objects,id',
            'accommodation_units' => 'required|integer|exists:accommodation_units,id|inObject:' . $this->input('accommodation_object'),
            'rate_plan' => 'required|integer|exists:rate_plans,id|forPlan:' . $this->input('accommodation_units') . ',' . $this->input('accommodation_object'),
            'date_range' => 'required|string',
            'adult_count' => 'required|integer',
            'children_under_count' => 'required|integer',
            'children_above_count' => 'required|integer',
        ];
    }
}
