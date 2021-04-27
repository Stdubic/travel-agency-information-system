<?php

namespace Modules\Accommodation\Http\Requests\AccommodationUnit;

use Modules\Accommodation\Entities\AccommodationUnit;
use Modules\Base\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class AccommodationUnitDeleteRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();

        $accommodationUnit = AccommodationUnit::find($this->all()['id']);

        if((!$user->can('delete', $accommodationUnit)) || (!$user->can('delete-accommodation-unit'))) {
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
            'id' => 'required|integer|exists:accommodation_units,id'
        ];
    }
}
