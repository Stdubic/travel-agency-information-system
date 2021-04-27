<?php

namespace Modules\Accommodation\Http\Requests\AccommodationUnitType;

use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccommodationUnitTypeCreateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        if(!$user->can('create-accommodation-unit-type')) {
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
