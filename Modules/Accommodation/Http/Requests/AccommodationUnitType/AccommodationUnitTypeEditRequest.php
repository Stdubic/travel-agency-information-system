<?php

namespace Modules\Accommodation\Http\Requests\AccommodationUnitType;

use Illuminate\Support\Facades\Auth;
use Modules\Base\Http\Requests\BaseRequest;

class AccommodationUnitTypeEditRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('update-accommodation-unit-type')) {
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
        return [

        ];
    }
}
